<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Locations;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class LocationController extends Controller
{
    public function locations()
    {
        $user = Auth::user();
        $locations = Locations::where('status', 1)->latest()->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.location.index', [
            'locations' => $locations,
            'user' => $user
        ]);
    }

    public function createLocation()
    {
        $user = Auth::user();
        return view('admin.location.create', [
            'user' => $user
        ]);
    }

    public function addLocation(Request $request)
    {
        $inputs = $request->all();
        $allLocations = Locations::where('status', 1)->get();
        $max = $allLocations->max('id');

        $location = new Locations();
        $location->id = ($max + 2 * 156);
        $location->name = $inputs['name'];
        $location->status = 1;
        $location->created_by = Auth::id();

        $location->save();
        return redirect()->route('admin.location.index');

    }

    public function editLocation(Request $request, $id)
    {
        $user = Auth::user();

        $location = Locations::find($id);
        if (!$location) {
            return response()->json(['error' => 'Location not found'], 404);
        }

        return view('admin.location.edit', [
            'location' => $location,
            'user' => $user,
        ]);
    }

    public function updateLocation(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);


        $location = Locations::find($id);
        $inputs = $request->all();
        if (!$location) {
            return response()->json(['error' => 'Location not found'], 404);
        }

        // Update location
        $location->update(['name' => $inputs['name'], 'updated_by' => Auth::id()]);

        // Redirect back to the locations list
        return redirect()->route('admin.location.index')->with('success', 'Location updated successfully');
    }

    public function deleteLocation(Request $request, $id)
    {
        $location = Locations::find($id);
        if (!$location) {
            return response()->json(['error' => 'Location not found'], 404);
        }

        $location->update(['status' => false, 'deleted_by' => Auth::id()]);

        return redirect()->route('admin.location.index')->with('success', 'Location deleted successfully');
    }


}
