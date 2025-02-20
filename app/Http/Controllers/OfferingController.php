<?php

namespace App\Http\Controllers;

use App\Models\Offering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferingController extends Controller
{
    // Show all offerings
    public function index()
    {
        $offerings = Offering::with('user')->get();
        return view('user.offering', compact('offerings'));
    }

    // Store a new offering
    public function store(Request $request)
    {
        $input = $request->all();        
        $user = Auth::user();
        $user_id = $user->id;

        $offeringdata = [
            'user_id' => $user_id,
            'name' => $input['name'],
            'long_description' => $input['long_description'],
            'short_description' => $input['short_description'],
            'location' => $input['location'],
            'help' => $input['help'],
            'categories' => $input['categories'],
            'tags' => $input['tags'],
            'type' => $input['type'],
            'booking-duration' => $input['booking-duration'],
            'booking-duration_time' => $input['booking-duration_time'],
            'calendar-display-mode' => $input['calendar-display-mode'],
            'max_bookings_per_block' => $input['max_bookings_per_block'],
            'minimum_block_bookable' => $input['minimum_block_bookable'],
            'into_future' => $input['into_future'],
            'buffer_period' => $input['buffer_period'],
            'all_dates' => $input['all_dates'],
            'confirmation_required' => isset($input['confirmation_required']) && $input['confirmation_required'] == 'on' ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $fileName = $image->getClientOriginalName();
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/offering/'), $fileName);
            $offeringdata['images'] = json_encode($fileName);   
            
        }

        

        $offering = Offering::create($offeringdata);
        return redirect()->route('offering')->with('success', 'Offering created successfully!');

       
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
