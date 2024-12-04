<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    /**
     * Add a new reminder.
     */
    public function addReminder(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // User must exist
            'appointment_id' => 'nullable|exists:appointments,id', // Optional, but must exist if provided
            'medication_name' => 'required|string',
            'reminder_date' => 'required|date', // Date in "YYYY-MM-DD" format
            'reminder_time' => 'required|date_format:H:i', // Time in "HH:MM" format
            'am_pm' => 'required|in:AM,PM', // Ensure only AM or PM
            'repeat' => 'nullable|in:none,daily,weekly,monthly', // Optional repeat frequency
            'sound' => 'nullable|string', // Optional sound
            'label' => 'nullable|string', // Optional label
            'ring_duration' => 'nullable|integer|min:5', // Optional, at least 5 seconds
            'snooze_duration' => 'nullable|integer|min:1', // Optional, at least 1 minute
        ]);

        // Create the reminder
        $reminder = Reminder::create([
            'user_id' => $request->user_id,
            'appointment_id' => $request->appointment_id, // Link to appointment if provided
            'medication_name' => $request->medication_name,
            'reminder_date' => $request->reminder_date,
            'reminder_time' => $request->reminder_time,
            'am_pm' => $request->am_pm,
            'repeat' => $request->repeat ?? 'none',
            'sound' => $request->sound ?? 'default',
            'label' => $request->label,
            'ring_duration' => $request->ring_duration ?? 30,
            'snooze_duration' => $request->snooze_duration ?? 5,
        ]);

        return response()->json([
            'message' => 'Reminder added successfully.',
            'reminder' => $reminder,
        ]);
    }

    /**
     * Get all reminders for a user.
     */
    public function getUserReminders($userId)
    {
        $reminders = Reminder::where('user_id', $userId)->with('appointment')->get();

        return response()->json([
            'reminders' => $reminders,
        ]);
    }

    /**
     * Skip a reminder.
     */
    public function skipReminder($reminderId)
    {
        $reminder = Reminder::find($reminderId);

        if (!$reminder) {
            return response()->json(['error' => 'Reminder not found.'], 404);
        }

        // Mark the reminder as skipped
        $reminder->update(['is_skipped' => true]);

        return response()->json(['message' => 'Reminder skipped successfully.']);
    }
}
