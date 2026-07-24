<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\ShiftReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShiftReportController extends Controller
{
    /**
     * نمایش فرم ثبت گزارش شیفت
     */
    public function create()
    {
        $devices = Device::where('status', 'active')->get();
        return view('shift-reports.create', compact('devices'));
    }

    /**
     * ثبت گزارش شروع شیفت (تحویل گرفتن شیفت)
     */
    public function startShift(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|exists:devices,id',
            'shots_used' => 'nullable|integer|min:0',
            'consumables_used' => 'nullable|json',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // بررسی اینکه آیا امروز قبلاً شیفت ثبت شده یا نه
            $existingShift = ShiftReport::where('user_id', Auth::id())
                ->where('shift_date', now()->toDateString())
                ->first();

            if ($existingShift) {
                return back()->with('error', 'شما امروز قبلاً شیفت خود را ثبت کرده‌اید.');
            }

            $shiftReport = new ShiftReport();
            $shiftReport->user_id = Auth::id();
            $shiftReport->shift_date = now()->toDateString();
            $shiftReport->start_time = now()->toTimeString();
            $shiftReport->device_id = $request->device_id;
            $shiftReport->shots_used = $request->shots_used ?? 0;
            $shiftReport->consumables_used = $request->consumables_used ? json_decode($request->consumables_used, true) : null;
            $shiftReport->notes = $request->notes;
            $shiftReport->is_received = true;
            $shiftReport->received_at = now();
            $shiftReport->save();

            // به‌روزرسانی شات مصرفی دستگاه
            if ($request->device_id && $request->shots_used) {
                $device = Device::find($request->device_id);
                if ($device) {
                    $device->used_shots += $request->shots_used;
                    $device->save();
                }
            }

            return redirect()->route('shift-reports.my')
                ->with('success', 'گزارش شروع شیفت با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ثبت گزارش شیفت: ' . $e->getMessage());
        }
    }

    /**
     * ثبت گزارش پایان شیفت
     */
    public function endShift(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shift_report_id' => 'required|exists:shift_reports,id',
            'end_notes' => 'nullable|string|max:500',
            'final_shots_used' => 'nullable|integer|min:0',
            'final_consumables_used' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $shiftReport = ShiftReport::findOrFail($request->shift_report_id);

            // بررسی اینکه شیفت متعلق به کاربر باشد
            if ($shiftReport->user_id !== Auth::id()) {
                abort(403, 'شما دسترسی به این گزارش ندارید.');
            }

            // بررسی اینکه شیفت قبلاً پایان نیافته باشد
            if ($shiftReport->end_time) {
                return back()->with('error', 'این شیفت قبلاً پایان یافته است.');
            }

            $shiftReport->end_time = now()->toTimeString();
            $shiftReport->notes = $request->end_notes ?? $shiftReport->notes;
            
            // به‌روزرسانی شات مصرفی نهایی
            if ($request->final_shots_used) {
                $additionalShots = $request->final_shots_used - $shiftReport->shots_used;
                if ($additionalShots > 0) {
                    $shiftReport->shots_used = $request->final_shots_used;
                    
                    // به‌روزرسانی شات مصرفی دستگاه
                    if ($shiftReport->device_id) {
                        $device = Device::find($shiftReport->device_id);
                        if ($device) {
                            $device->used_shots += $additionalShots;
                            $device->save();
                        }
                    }
                }
            }

            if ($request->final_consumables_used) {
                $shiftReport->consumables_used = json_decode($request->final_consumables_used, true);
            }

            $shiftReport->save();

            return redirect()->route('shift-reports.my')
                ->with('success', 'گزارش پایان شیفت با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ثبت پایان شیفت: ' . $e->getMessage());
        }
    }

    /**
     * تأیید گزارش شیفت توسط مدیر/منشی
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shift_report_id' => 'required|exists:shift_reports,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $shiftReport = ShiftReport::findOrFail($request->shift_report_id);

            // بررسی اینکه شیفت پایان یافته باشد
            if (!$shiftReport->end_time) {
                return back()->with('error', 'این شیفت هنوز پایان نیافته است.');
            }

            // بررسی اینکه قبلاً تأیید نشده باشد
            if ($shiftReport->verified_by) {
                return back()->with('error', 'این گزارش قبلاً تأیید شده است.');
            }

            $shiftReport->verified_by = Auth::id();
            $shiftReport->save();

            return redirect()->route('shift-reports.manage')
                ->with('success', 'گزارش شیفت با موفقیت تأیید شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در تأیید گزارش: ' . $e->getMessage());
        }
    }

    /**
     * نمایش لیست گزارش‌های شیفت کاربر جاری
     */
    public function myReports()
    {
        $reports = ShiftReport::where('user_id', Auth::id())
            ->with(['device', 'verifiedBy'])
            ->orderBy('shift_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(20);

        return view('shift-reports.my', compact('reports'));
    }

    /**
     * نمایش لیست همه گزارش‌های شیفت برای مدیریت (منشی/مدیر)
     */
    public function index()
    {
        $reports = ShiftReport::with(['user', 'device', 'verifiedBy'])
            ->orderBy('shift_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(30);

        $pendingReports = ShiftReport::with(['user', 'device'])
            ->whereNull('verified_by')
            ->whereNotNull('end_time')
            ->get();

        return view('shift-reports.index', compact('reports', 'pendingReports'));
    }

    /**
     * نمایش جزئیات یک گزارش شیفت
     */
    public function show($id)
    {
        $report = ShiftReport::with(['user', 'device', 'verifiedBy'])
            ->findOrFail($id);

        // بررسی دسترسی
        if (Auth::id() !== $report->user_id && !Auth::user()->isStaff()) {
            abort(403, 'شما دسترسی به این گزارش ندارید.');
        }

        return view('shift-reports.show', compact('report'));
    }
}