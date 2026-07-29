<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\UserPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppointmentsController extends Controller
{
    /**
     * نمایش فرم درخواست نوبت (مشتری)
     */
    public function create()
    {
        $services = Service::where('is_active', true)->get();
        return view('patient.appointments.booking', compact('services'));
    }

    /**
     * ثبت درخواست نوبت (مشتری)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'client_notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $appointment = new Appointment();
            $appointment->user_id = Auth::id();
            $appointment->service_id = $request->service_id;
            $appointment->appointment_date = $request->appointment_date;
            $appointment->appointment_time = $request->appointment_time;
            $appointment->duration_minutes = Service::find($request->service_id)->duration_minutes ?? 30;
            $appointment->status = 'pending';
            $appointment->client_notes = $request->client_notes;
            $appointment->amount = Service::find($request->service_id)->price ?? 0;
            $appointment->payment_status = 'unpaid';
            $appointment->save();

            return redirect()->route('appointments.my')
                ->with('success', 'درخواست نوبت با موفقیت ثبت شد. منتظر تأیید پرسنل باشید.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ثبت نوبت: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * نمایش لیست نوبت‌های کاربر (مشتری)
     */
    public function myAppointments()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->with(['service', 'assignedStaff'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        return view('appointments.my', compact('appointments'));
    }

    /**
     * نمایش لیست درخواست‌های نوبت برای پرسنل (مدیریت)
     */
    public function index()
    {
        $appointments = Appointment::with(['user', 'service'])
            ->where('status', 'pending')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(20);

        $confirmedAppointments = Appointment::with(['user', 'service', 'assignedStaff'])
            ->whereIn('status', ['confirmed', 'in_progress'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();
        $services = Service::get();
        return view('Employee.appointments.booking', compact('appointments', 'confirmedAppointments' , 'services'));
    }

    /**
     * تأیید نوبت توسط پرسنل
     */
    public function confirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|exists:appointments,id',
            'assigned_staff_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $appointment = Appointment::findOrFail($request->appointment_id);
            
            // بررسی اینکه نوبت در وضعیت pending باشد
            if ($appointment->status !== 'pending') {
                return back()->with('error', 'این نوبت قبلاً تعیین وضعیت شده است.');
            }

            $appointment->assigned_staff_id = $request->assigned_staff_id;
            $appointment->status = 'confirmed';
            $appointment->confirmed_at = now();
            $appointment->save();

            return redirect()->route('appointments.manage')
                ->with('success', 'نوبت با موفقیت تأیید شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در تأیید نوبت: ' . $e->getMessage());
        }
    }

    /**
     * لغو نوبت توسط پرسنل
     */
    public function cancel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|exists:appointments,id',
            'cancel_reason' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $appointment = Appointment::findOrFail($request->appointment_id);
            
            if ($appointment->status !== 'pending' && $appointment->status !== 'confirmed') {
                return back()->with('error', 'این نوبت قابل لغو نیست.');
            }

            $appointment->status = 'cancelled';
            $appointment->cancelled_at = now();
            $appointment->cancel_reason = $request->cancel_reason;
            $appointment->save();

            return redirect()->route('appointments.manage')
                ->with('success', 'نوبت با موفقیت لغو شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در لغو نوبت: ' . $e->getMessage());
        }
    }

    /**
     * تکمیل نوبت توسط پرسنل
     */
    public function complete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|exists:appointments,id',
            'staff_notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $appointment = Appointment::findOrFail($request->appointment_id);
            
            if ($appointment->status !== 'confirmed' && $appointment->status !== 'in_progress') {
                return back()->with('error', 'این نوبت قابل تکمیل نیست.');
            }

            $appointment->status = 'completed';
            $appointment->completed_at = now();
            $appointment->staff_notes = $request->staff_notes;
            $appointment->save();

            // اضافه کردن امتیاز به کاربر
            $user = $appointment->user;
            $user->points += 10;
            $user->save();

            // ثبت تاریخچه امتیاز
            $userPoint = new UserPoint();
            $userPoint->user_id = $user->id;
            $userPoint->points = 10;
            $userPoint->type = 'earned';
            $userPoint->source = 'appointment_completed';
            $userPoint->source_id = $appointment->id;
            $userPoint->description = 'امتیاز تکمیل نوبت: ' . $appointment->service->name;
            $userPoint->save();

            return redirect()->route('appointments.manage')
                ->with('success', 'نوبت با موفقیت تکمیل شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در تکمیل نوبت: ' . $e->getMessage());
        }
    }

    /**
     * نمایش جزئیات یک نوبت
     */
    public function show($id)
    {
        $appointment = Appointment::with(['user', 'service', 'assignedStaff'])
            ->findOrFail($id);

        // بررسی دسترسی: فقط خود کاربر یا پرسنل
        if (Auth::id() !== $appointment->user_id && !Auth::user()->isStaff()) {
            abort(403, 'شما دسترسی به این نوبت ندارید.');
        }

        return view('appointments.show', compact('appointment'));
    }

    /**
     * نمایش تاریخچه نوبت‌های کاربر (برای بریف)
     */
    public function history($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        // اگر کاربر پرسنل است و userId ارسال شده، می‌تواند تاریخچه دیگران را ببیند
        if (Auth::user()->isStaff() && $userId !== Auth::id()) {
            $appointments = Appointment::where('user_id', $userId)
                ->with(['service', 'assignedStaff'])
                ->orderBy('appointment_date', 'desc')
                ->get();
        } else {
            $appointments = Appointment::where('user_id', Auth::id())
                ->with(['service', 'assignedStaff'])
                ->orderBy('appointment_date', 'desc')
                ->get();
        }

        return view('appointments.history', compact('appointments'));
    }
}