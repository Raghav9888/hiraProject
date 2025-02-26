<?php

namespace App\Http\Controllers\Practitioner;

use App\Http\Controllers\Controller;
use App\Models\Offering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferingController extends Controller
{
    // Show all offerings
    public function index()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        $offerings = Offering::with('user')->get();
        return view('user.offering', compact('user', 'userDetails', 'offerings'));
    }

    public function addOffering()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;

        return view('user.add_offering');
    }

    // Store a new offering
    public function store(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $user_id = $user->id;


        $offeringData = [
            'user_id' => $user_id,

            "name" => $input['name'],
            "long_description" => $input['long_description'],
            "short_description" => $input['short_description'],
            "location" => json_encode($input['location']),
            "help" => json_encode($input['help']),
            "categories" => json_encode($input['categories']),
            "tags" => json_encode($input['tags']),
            "offering_type" => $input['offering_type'],
            "booking_duration" => json_encode($input['booking_duration']),
            "from_date" => $input['from_date'],
            "to_date" => $input['to_date'],
            "availability" => $input['availability'],
            "availability_type" => $input['availability_type'],
            "client_price" => $input['client_price'],
            "tax_amount" => $input['tax_amount'],
            "scheduling_window" => $input['scheduling_window'],
            "buffer_time" => $input['buffer_time'],
            "email_template" => $input['email_template'],
            "intake_form" => $input['intake_form'],
            "is_cancelled" => $input['is_cancelled'],
            "cancellation_time_slot" => $input['cancellation_time_slot'],
            "is_confirmation" => $input['is_confirmation'] == 'on',
//            remove from database
            'type' => 'null',
        ];

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;
            $image->move(public_path('uploads/practitioners/' . $user_id . '/feature/'), $imageName);
            $offeringData['featured_image'] = $imageName;
        }


        $offering = Offering::create($offeringData);
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

    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        $offering = Offering::findOrFail($id);
        return view('user.offering_edit', compact('user', 'userDetails', 'offering'));
    }

    // Delete an offering
    public function destroy($id)
    {
        $offering = Offering::findOrFail($id);
        $offering->delete();

        return response()->json(['message' => 'Offering deleted successfully!']);
    }
}
