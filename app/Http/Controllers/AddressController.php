<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    //
    public function getAddress(Request $request)
    {
        $user = $request->user(); // Authenticated user

        $address = $user->address; // Retrieve the related address via the relationship

        if (!$address) {
            return response()->json([
                'error' => 'Address not found',
                'message' => 'The user does not have an address yet.',
            ], 404);
        }

        return response()->json(['address' => $address], 200);
    }

//
    public function updateAddress(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $user = $request->user(); // Assuming user authentication
        
        $user->address()->updateOrCreate([], [
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'address' => $validated['address'] ?? null,
        ]); // Update or create address

        return response()->json(['message' => 'Address updated successfully']);
    }

}
