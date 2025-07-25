<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $communities = Community::where('status',1)->with(['admin'])->paginate(10);

        return view('admin.community.index', [
            'communities' => $communities,
            'user' =>$user,
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        return view('admin.community.create',['user' =>$user,]);
    }

    public function store(Request $request)
    {


        $data = [
            'admin_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => 1

        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/admin/community/'), $imageName);

            $data['image'] = $imageName;
        }

        $community = Community::create($data);

        if ($community) {
            return redirect()->route('admin.community.index')->with('success', 'Community created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create community.');
        }

    }

    /**
     * Show the form for editing the specified feedback.
     */
    public function edit(Community $community)
    {
        $user = Auth::user();

        return view('admin.community.edit', compact('community','user'));
    }

    public function update(Request $request, Community $community)
    {
        $data = [
            'admin_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => 1
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/admin/community/'), $imageName);

            $data['image'] = $imageName;
        }

        $community->update($data);

        return redirect()->route('admin.community.index')->with('success', 'Community updated successfully.');

    }

    public function destroy(Community $community)
    {
        $community->update(['status' => 'inactive']);

        return redirect()->route('admin.community.index')->with('success', 'Community deleted successfully.');
    }

}
