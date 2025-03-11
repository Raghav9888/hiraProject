<?php

namespace App\Http\Controllers\Practitioner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\HowIHelp;
use App\Models\IHelpWith;
use App\Models\Locations;
use App\Models\Offering;
use App\Models\PractitionerTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferingController extends Controller
{
    // Show all offerings
    public function index()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        $offerings = Offering::where('user_id', $user->id)->get();
        $categories = Category::get();
        $practitionerTag = PractitionerTag::get();
        $IHelpWith = IHelpWith::get();
        $HowIHelp = HowIHelp::get();
        return view('user.offering', compact('user', 'userDetails', 'offerings', 'categories', 'practitionerTag'));
    }

    public function addOffering()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        $categories = Category::get();
        $practitionerTag = PractitionerTag::get();
        $IHelpWith = IHelpWith::get();
        $HowIHelp = HowIHelp::get();
        $locations = Locations::get();
        return view('user.add_offering', compact('user', 'userDetails', 'categories', 'practitionerTag', 'IHelpWith', 'HowIHelp', 'locations'));
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
            "location" => isset($input['location']) && $input['location'] ? $input['location'] : null,
            "help" => isset($input['help']) && $input['help'] ? json_encode($input['help']) : null,
            "categories" => isset($input['categories']) && $input['categories'] ? json_encode($input['categories']) : null,
            "tags" => isset($input['tags']) && $input['tags'] ? json_encode($input['tags']) : null,
            "offering_type" => $input['offering_type'],
            "booking_duration" => $input['booking_duration_offering'],
            "from_date" => $input['from_date_offering'],
            "to_date" => $input['to_date_offering'],
//            "availability" => (isset($input['availability']) && $input['availability'] == 'on') ? 1 : 0,
            "availability_type" => $input['availability_type_offering'],
            "client_price" => $input['client_price_offering'],
            "tax_amount" => $input['tax_amount_offering'],
            "scheduling_window" => $input['scheduling_window_offering'],
            "email_template" => $input['email_template_offering'],
            "intake_form" => $input['intake_form_offering'],
            "is_cancelled" => (isset($input['is_cancelled_offering']) && ($input['is_cancelled_offering'] == 'on')) ? 1 : 0,
            "cancellation_time_slot" => $input['cancellation_time_slot_offering'] ?? null,
            "is_confirmation" => (isset($input['is_confirmation_offering']) && $input['is_confirmation_offering'] == 'on') ? 1 : 0,
        ];

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;
            $image->move(public_path('uploads/practitioners/' . $user_id . '/offering/'), $imageName);
            $offeringData['featured_image'] = $imageName;
        }
        $offering = Offering::create($offeringData);
        
        $data = [
            'offering_id' => $offering->id,
            'specify' => $input['specify_event'],
            'date_and_time' => $input['date_and_time_event'],
            'recurring_days' => $input['recurring_days_event'],
            'event_duration' => $input['event_duration_event'],
            'sports' => $input['sports_event'],
            'scheduling_window' => $input['scheduling_window_event'],
            'email_template' => $input['email_template_event'],
            'client_price' => $input['client_price_event'],
            'tax_amount' => $input['tax_amount_event'],
            'intake_form' => $input['intake_form_event'],
            'is_cancelled' => (isset($input['is_cancelled_event']) && ($input['is_cancelled_event'] == 'on')) ? 1 : 0,
            'cancellation_time_slot' => $input['cancellation_time_slot_event'] ?? null,
            'is_confirmation' => (isset($input['is_confirmation_event']) && $input['is_confirmation_event'] == 'on') ? 1 : 0,
        ];

        $event = Event::create($data);

        return redirect()->route('offering')->with('success', 'Offering created successfully!');
    }

    public function duplicate($id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        // Find the original offering
        $originalOffering = Offering::findOrFail($id);

        // Create a new offering with duplicated data
        $duplicateOffering = $originalOffering->replicate();
        $duplicateOffering->user_id = $user_id; // Assign the current user ID if necessary
        $duplicateOffering->name = $originalOffering->name . ' (Copy)';

        // Handle the featured image duplication if it exists
        if ($originalOffering->featured_image) {
            $originalImagePath = public_path('uploads/practitioners/' . $user_id . '/offering/' . $originalOffering->featured_image);
            $newImageName = time() . '_copy.' . pathinfo($originalOffering->featured_image, PATHINFO_EXTENSION);
            $newImagePath = public_path('uploads/practitioners/' . $user_id . '/offering/' . $newImageName);

            if (file_exists($originalImagePath)) {
                copy($originalImagePath, $newImagePath);
                $duplicateOffering->featured_image = $newImageName;
            }
        }

        $duplicateOffering->save();

        return redirect()->route('offering')->with('success', 'Offering duplicated successfully!');
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
        $event = Event::where('offering_id', $offeringId)->first();

        $offeringData = [
            'user_id' => $user_id,
            "name" => $input['name'],
            "long_description" => $input['long_description'],
            "short_description" => $input['short_description'],
            "location" => isset($input['location']) && $input['location'] ? $input['location'] : null,
            "help" => isset($input['help']) && $input['help'] ? json_encode($input['help']) : null,
            "categories" => isset($input['categories']) && $input['categories'] ? json_encode($input['categories']) : null,
            "tags" => isset($input['tags']) && $input['tags'] ? json_encode($input['tags']) : null,
            "offering_type" => $input['offering_type'],
            "booking_duration" => $input['booking_duration_offering'],
            "from_date" => $input['from_date_offering'],
            "to_date" => $input['to_date_offering'],
//            "availability" => (isset($input['availability']) && $input['availability'] == 'on') ? 1 : 0,
            "availability_type" => $input['availability_type_offering'],
            "client_price" => $input['client_price_offering'],
            "tax_amount" => $input['tax_amount_offering'],
            "scheduling_window" => $input['scheduling_window_offering'],
            "email_template" => $input['email_template_offering'],
            "intake_form" => $input['intake_form_offering'],
            "is_cancelled" => (isset($input['is_cancelled_offering']) && ($input['is_cancelled_offering'] == 'on')) ? 1 : 0,
            "cancellation_time_slot" => $input['cancellation_time_slot_offering'] ?? null,
            "is_confirmation" => (isset($input['is_confirmation_offering']) && $input['is_confirmation_offering'] == 'on') ? 1 : 0,
        ];



        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;
            $image->move(public_path('uploads/practitioners/' . $user_id . '/offering/'), $imageName);
            $offeringData['featured_image'] = $imageName;
        }

        $data = [
            'specify' => $input['specify_event'],
            'date_and_time' => $input['date_and_time_event'],
            'recurring_days' => $input['recurring_days_event'],
            'event_duration' => $input['event_duration_event'],
            'sports' => $input['sports_event'],
            'scheduling_window' => $input['scheduling_window_event'],
            'email_template' => $input['email_template_event'],
            'client_price' => $input['client_price_event'],
            'tax_amount' => $input['tax_amount_event'],
            'intake_form' => $input['intake_form_event'],
            'is_cancelled' => (isset($input['is_cancelled_event']) && ($input['is_cancelled_event'] == 'on')) ? 1 : 0,
            'cancellation_time_slot' => $input['cancellation_time_slot_event'] ?? null,
            'is_confirmation' => (isset($input['is_confirmation_event']) && $input['is_confirmation_event'] == 'on') ? 1 : 0,
        ];

        $offering->update($offeringData);
        if (!$event) {
            $event = Event::create(array_merge($data, ['offering_id' => $offeringId]));
        } else {
            $event->update($data);
        }

        return redirect()->route('offering')->with('success', 'Offering updated successfully!');
    }


    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        $offering = Offering::findOrFail($id);

        $categories = Category::get();
        $practitionerTag = PractitionerTag::get();
        $IHelpWith = IHelpWith::get();
        $HowIHelp = HowIHelp::get();
        $locations = Locations::get();
        return view('user.edit_offering', compact('user', 'userDetails', 'locations', 'offering', 'categories', 'practitionerTag', 'IHelpWith', 'HowIHelp'));
    }

    // Delete an offering
    public function delete($id)
    {
        $offering = Offering::findOrFail($id);
        $offering->delete();

        return redirect()->route('offering')->with('success', 'Offering updated successfully!');
    }
}
