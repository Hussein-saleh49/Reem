<?php
// app/Http/Controllers/MedicationController.php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $medications = Medication::where('name', 'LIKE', "%$query%")
            ->orWhere('active_ingredient', 'LIKE', "%$query%")
            ->paginate(10); // Paginate the results

        // Increment search count
        foreach ($medications as $medication) {
            $medication->increment('search_count');
        }

        return response()->json($medications);
    }

    public function topSearches()
    {
        $topMedications = Medication::orderBy('search_count', 'desc')->take(5)->get();
        return response()->json($topMedications);
    }
}
