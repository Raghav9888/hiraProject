<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Locations;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class CategoryController
{

    public function index()
    {
        $user = Auth::user();

        $categories = Category::where('status', 1)->latest()->orderBy('created_at', 'desc')->paginate(10);

        $userDetail = $user->userDetail;
        return view('admin.category.index', [
            'categories' => $categories,
            'user' => $user,
            'userDetail' => $userDetail
        ]);
    }

    public function create()
    {
        $user = Auth::user();


        $userDetail = $user->userDetail;
        return view('admin.category.create', [
            'user' => $user,
            'userDetail' => $userDetail
        ]);
    }

    public function store(Request $request)
    {


        $user = Auth::user();
        $user_id = $user->id;

        $category = new Category();

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->status = 1;
        $category->created_by = Auth::id();

        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'Category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        return view('admin.category.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        
        $user = Auth::user();
        $user_id = $user->id;

        $category = Category::where('id', $id)->first();

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->updated_by = Auth::id();

        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully');
    }


    public function destroy(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Location not found'], 404);
        }

        $category->update(['status' => false, 'deleted_by' => Auth::id()]);

        return redirect()->route('admin.category.index')->with('success', 'Location deleted successfully');
    }
}
