<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function consultationIndex(Request $request)
    {
        $query = Consultation::with([
            'user',
            'service',
            'assignedTo',
            'doctorWorkingTimeSlot',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($user) use ($search) {
                        $user->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('phone', 'LIKE', "%{$search}%");
                    });
            });
        }

        $consultations = $query->latest()->paginate(15);

        return view('Employee.consultation.index', compact('consultations'));
    }

    public function consultationDetails($id)
    {
        $consultation = Consultation::with([
            'user',
            'service',
            'assignedTo',
            'doctorWorkingTimeSlot',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'consultation' => [
                ...$consultation->toArray(),
                'consultation_date' => $consultation->consultation_date
                    ? Verta::instance($consultation->consultation_date)->format('Y/m/d')
                    : null,
                'assigned_at' => $consultation->assigned_at
                    ? Verta::instance($consultation->assigned_at)->format('Y/m/d H:i')
                    : null,
            ],
        ]);
    }
}
