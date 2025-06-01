<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HowIHelp;
use App\Models\IHelpWith;
use App\Models\Locations;
use App\Models\Offering;
use App\Models\PractitionerTag;
use Illuminate\Support\Facades\Auth;

class OfferingEventController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        $offerings = Offering::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::where('status', 1)->get();
        $practitionerTag = PractitionerTag::get();
        $IHelpWith = IHelpWith::get();
        $HowIHelp = HowIHelp::get();
        return view('admin.offeringEvent.index', [
            'offerings' => $offerings,
            'categories' => $categories,
            'userDetails' => $userDetails,
            'practitionerTag' => $practitionerTag,
            'IHelpWith' => $IHelpWith,
            'HowIHelp' => $HowIHelp,
        ]);

    }
    public function create()
    {
        $categories = Category::where('status', 1)->latest()->orderBy('created_at', 'desc')->paginate(10);
        $practitionerTag = PractitionerTag::get();
        return view('admin.offeringEvent.create',[
            'categories' => $categories,
            'practitionerTag' => $practitionerTag,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $userDetails = $user->userDetail;
        $offering = Offering::findOrFail($id);

        $categories = Category::where('status', 1)->get();
        $practitionerTag = PractitionerTag::get();
        $IHelpWith = IHelpWith::get();
        $HowIHelp = HowIHelp::get();
        $defaultLocations = Locations::where('status', 1)->get();
        $locations = [];
        foreach ($defaultLocations as $location) {
            $locations[$location->id] = $location->name;
        }
        return view('admin.offeringEvent.edit',[
            'user' => $user,
            'userDetails' => $userDetails,
            'offering' => $offering,
            'categories' => $categories,
            'practitionerTag' => $practitionerTag,
            'IHelpWith' => $IHelpWith,
            'HowIHelp' => $HowIHelp,
            'defaultLocations' => $locations
        ]);
    }
}
