<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile() {
        $user = User::findOrFail(1);

        $data = $user->toArray();

        $data['birth_date'] = $user->birth_date
            ? verta($user->birth_date)->format('j F Y')
            : null;

        return response()->json([
            'success' => true,
            'message' => 'اطلاعات پروفایل با موفقیت دریافت شد.',
            'data' => [
                'user' => $data,
            ],
        ]);
    }
    public function doctors($id = null)
    {
        $query = User::whereHas('roles', function ($query) {
            $query->where('name', 'doctor');
        });

        if ($id) {
            $query->whereHas('services', function ($query) use ($id) {
                $query->whereKey($id);
            });
        }

        $doctors = $query->with('services')->get();

        foreach ($doctors as $doctor) {
            if ($id) {
                $service = $doctor->services->firstWhere('id', $id);
            } else {
                $service = $doctor->services->first();
            }

            $doctor->ability = $service?->name;
        }

        return response()->json([
            'success' => true,
            'message' => 'اطلاعات دکتر ها با موفقیت دریافت شد.',
            'data' => [
                'user' => $doctors,
            ],
        ]);
    }
    public function toggle($toggleName, $value)
    {
        $user = User::findOrFail(1);

        $fields = [
            'appointment' => 'appointment_reminders',
            'sms' => 'sms_notifications',
            'email' => 'email_updates',
            'marketing' => 'marketing_messages',
        ];

        if (!isset($fields[$toggleName])) {
            return response()->json([
                'success' => false,
                'message' => 'تنظیم مورد نظر معتبر نیست.',
            ], 400);
        }

        $value = (int) $value;

        if (!in_array($value, [0, 1], true)) {
            return response()->json([
                'success' => false,
                'message' => 'مقدار باید 0 یا 1 باشد.',
            ], 400);
        }

        $field = $fields[$toggleName];

        $user->$field = $value;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'تنظیم اعلان با موفقیت تغییر کرد.',
            'data' => [
                'field' => $field,
                'value' => $value,
            ],
        ]);
    }
}
