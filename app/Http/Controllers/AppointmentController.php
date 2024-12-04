<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Measurement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Get today's appointments for a specific user.
     */
    public function getTodayAppointments($userId)
    {
        $today = Carbon::today();

        $appointments = Appointment::where('user_id', $userId)
            ->whereDate('appointment_time', $today)
            ->get();

        return response()->json($appointments);
    }

    /**
     * Add a measurement with day, date, and medication name.
     */
    public function addMeasurement(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'user_id' => 'required|exists:users,id', // User must exist
            'date' => 'required|date', // Full date (e.g., "2024-11-27")
            'medication_name' => 'required|string', // Medication name must be provided
        ]);

        // Extract the day name from the date
        $day = Carbon::parse($request->date)->format('l'); // e.g., "Monday"

        // Create the measurement
        $measurement = new Measurement();
        $measurement->user_id = $request->user_id;
        $measurement->day = $day;
        $measurement->date = $request->date;
        $measurement->medication_name = $request->medication_name;
        $measurement->save();

        // Create an appointment and link it to the measurement
        $appointment = new Appointment();
        $appointment->user_id = $request->user_id;
        $appointment->name = $request->medication_name; // Use the medication name for the appointment
        $appointment->appointment_time = $request->date; // Set the appointment time to the measurement date
        $appointment->measurement_id = $measurement->id; // Link the appointment to the measurement
        $appointment->is_skipped = false; // Default to not skipped
        $appointment->save();

        // Return response with both measurement and appointment
        return response()->json([
            'message' => 'Measurement and appointment added successfully.',
            'measurement' => $measurement,
            'appointment' => $appointment,
        ]);
    }

    /**
     * Mark an appointment as skipped.
     */
    public function skipAppointment($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);

        if ($appointment) {
            $appointment->is_skipped = true;
            $appointment->save();

            return response()->json(['message' => 'Appointment skipped successfully.']);
        }

        return response()->json(['error' => 'Appointment not found.'], 404);
    }
}
