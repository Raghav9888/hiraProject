<?php

namespace App\Http\Controllers;

use App\Models\Offering;
use Illuminate\Http\Request;

class OfferingController extends Controller
{
    // Show all offerings
    public function index()
    {
        $offerings = Offering::with('user')->get();
        return response()->json($offerings);
    }

    // Store a new offering
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'long_description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'location' => 'nullable|array',
            'help' => 'nullable|string',
            'categories' => 'nullable|string',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|string',
            'type' => 'nullable|string',
            'booking_duration' => 'nullable|array',
            'calendar_display_mode' => 'nullable|string',
            'confirmation_requires' => 'boolean',
            'cancel' => 'boolean',
            'maximum_block' => 'nullable|array',
            'period_booking_period' => 'nullable|string',
            'booking_default_date_availability' => 'nullable|string',
            'booking_check_availability_against' => 'nullable|string',
            'restrict_days' => 'nullable|array',
            'block_start' => 'nullable|string',
            'range' => 'nullable|array',
            'cost' => 'nullable|array',
            'cost_range' => 'nullable|array',
        ]);

        $offering = Offering::create($validated);

        return response()->json(['message' => 'Offering created successfully!', 'data' => $offering], 201);
    }

    // Show a single offering
    public function show($id)
    {
        $offering = Offering::with('user')->findOrFail($id);
        return response()->json($offering);
    }

    // Update an offering
    public function update(Request $request, $id)
    {
        $offering = Offering::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'long_description' => 'sometimes|string',
            'short_description' => 'sometimes|string|max:500',
            'location' => 'sometimes|array',
            'help' => 'sometimes|string',
            'categories' => 'sometimes|string',
            'tags' => 'sometimes|string',
            'featured_image' => 'sometimes|string',
            'type' => 'sometimes|string',
            'booking_duration' => 'sometimes|array',
            'calendar_display_mode' => 'sometimes|string',
            'confirmation_requires' => 'sometimes|boolean',
            'cancel' => 'sometimes|boolean',
            'maximum_block' => 'sometimes|array',
            'period_booking_period' => 'sometimes|string',
            'booking_default_date_availability' => 'sometimes|string',
            'booking_check_availability_against' => 'sometimes|string',
            'restrict_days' => 'sometimes|array',
            'block_start' => 'sometimes|string',
            'range' => 'sometimes|array',
            'cost' => 'sometimes|array',
            'cost_range' => 'sometimes|array',
        ]);

        $offering->update($validated);

        return response()->json(['message' => 'Offering updated successfully!', 'data' => $offering]);
    }

    // Delete an offering
    public function destroy($id)
    {
        $offering = Offering::findOrFail($id);
        $offering->delete();

        return response()->json(['message' => 'Offering deleted successfully!']);
    }
}
