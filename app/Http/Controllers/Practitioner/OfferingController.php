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
            "booking_duration" => $input['booking_duration'],
            "from_date" => new \DateTime($input['from_date']),
            "to_date" => isset($input['to_date']) ? new \DateTime($input['to_date']) : null,
            "availability" => (isset($input['availability']) && $input['availability'] == 'on') ? 1 : 0,
            "availability_type" => $input['availability_type'],
            "client_price" => $input['client_price'],
            "tax_amount" => $input['tax_amount'],
            "scheduling_window" => $input['scheduling_window'],
            "buffer_time" => new \DateTime($input['buffer_time']),
            "email_template" => $input['email_template'],
            "intake_form" => $input['intake_form'],
            "is_cancelled" => (isset($input['is_cancelled']) && ($input['is_cancelled'] == 'on')) ? 1 : 0,
            "cancellation_time_slot" => $input['cancellation_time_slot'] ?? null,
            "is_confirmation" => (isset($input['is_confirmation']) && $input['is_confirmation'] == 'on') ? 1 : 0,
        ];

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;
            $image->move(public_path('uploads/practitioners/' . $user_id . '/offering/'), $imageName);
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
    public function update(Request $request)
    {

        $input = $request->all();

        $user = Auth::user();
        $user_id = $user->id;

        $offeringId = $input['id'];

        $offering = Offering::findOrFail($offeringId);

        $offeringData = [
            "name" => $input['name'],
            "long_description" => $input['long_description'],
            "short_description" => $input['short_description'],
            "location" => json_encode($input['location']),
            "help" => json_encode($input['help']),
            "categories" => json_encode($input['categories']),
            "tags" => json_encode($input['tags']),
            "offering_type" => $input['offering_type'],
            "booking_duration" => $input['booking_duration'],
            "from_date" => new \DateTime($input['from_date']),
            "to_date" => new \DateTime($input['to_date']),
            "availability" => (isset($input['availability']) && $input['availability'] == 'on') ? 1 : 0,
            "availability_type" => $input['availability_type'],
            "client_price" => $input['client_price'],
            "tax_amount" => $input['tax_amount'],
            "scheduling_window" => $input['scheduling_window'],
            "buffer_time" => new \DateTime($input['buffer_time']),
            "email_template" => $input['email_template'],
            "intake_form" => $input['intake_form'],
            "is_cancelled" => (isset($input['is_cancelled']) && ($input['is_cancelled'] == 'on')) ? 1 : 0,
            "cancellation_time_slot" => $input['cancellation_time_slot'] ?? null,
            "is_confirmation" => (isset($input['is_confirmation']) && $input['is_confirmation'] == 'on') ? 1 : 0,
        ];

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;
            $image->move(public_path('uploads/practitioners/' . $user_id . '/offering/'), $imageName);
            $offeringData['featured_image'] = $imageName;
        }

        $offering->update($offeringData);

        return redirect()->route('offering')->with('success', 'Offering updated successfully!');
    }


    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        $offering = Offering::findOrFail($id);
        return view('user.edit_offering', compact('user', 'userDetails', 'offering'));
    }

    // Delete an offering
    public function delete($id)
    {
        $offering = Offering::findOrFail($id);
        $offering->delete();

        return response()->json(['message' => 'Offering deleted successfully!']);
    }
}
