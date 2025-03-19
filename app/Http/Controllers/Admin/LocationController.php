<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Locations;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function locations()
    {
        $user = Auth::user();
        $locations = Locations::latest()->paginate(10);
        return view('admin.location.index',[
            'locations' => $locations,
            'user' => $user
        ]);
    }
    public function createLocation()
    {
        return view('admin.location.create');
    }
}
