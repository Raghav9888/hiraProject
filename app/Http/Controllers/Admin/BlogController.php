<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $blogs = Blog::latest()->paginate(10);
        $userDetail = $user->userDetail;
        return view('admin.blogs.index', compact('user','userDetail','blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $categories = Category::where('status',1)->get();
        return view("admin.blogs.create",compact('user', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:blogs,name',
//            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        $user = Auth::user();
        $user_id = $user->id;
        // Generate Unique Slug
        $slug = Str::slug($request->name);
        $count = Blog::where('slug', 'LIKE', "{$slug}%")->count();
        $finalSlug = $count ? "{$slug}-{$count}" : $slug;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/admin/blog/'), $imageName);

        }
        $tags = [];
        if($request->tags){
            $tags = explode(',', $request->tags);
        }

        // Create Blog Post
        $blog = new Blog();
        $blog->name = $request->name;
        $blog->description = $request->description;
        $blog->date = $request->date;
        $blog->author = $request->author;
        $blog->tags = json_encode($tags);
        $blog->slug = $finalSlug;
        $blog->image = $imageName ?? null; // Save image path
        $blog->category_id = $request->category;
        $blog->save();

        return back()->with('success', 'Blog post created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $blog = Blog::findOrFail($id);
        $categories = Category::where('status',1)->get();
        return view('admin.blogs.edit', compact('blog', 'categories','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:blogs,name,' . $blog->id,
//            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        $user = Auth::user();
        $user_id = $user->id;

        // Update Slug Only If Name Changes
        if ($request->name !== $blog->name) {
            $slug = Str::slug($request->name);
            $count = Blog::where('slug', 'LIKE', "{$slug}%")->where('id', '!=', $blog->id)->count();
            $finalSlug = $count ? "{$slug}-{$count}" : $slug;
            $blog->slug = $finalSlug;
        }

        // Handle Image Upload & Delete Old Image
        if ($request->hasFile('image')) {
            // Delete Old Image If Exists
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }

            // Upload New Image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/admin/blog/'), $imageName);
            $blog->image = $imageName;
        }

        $tags = [];
        if($request->tags){
            $tags = explode(',', $request->tags);
        }
        // Update Blog Data
        $blog->name = $request->name;
        $blog->description = $request->description;
        $blog->category_id = $request->category;
        $blog->date = $request->date;
        $blog->author = $request->author;
        $blog->tags = json_encode($tags);
        $blog->save();

        return back()->with('success', 'Blog post updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        // Delete Blog Image
        if ($blog->image && file_exists(public_path($blog->image))) {
            unlink(public_path($blog->image));
        }

        $blog->delete();

        return back()->with('success', 'Blog deleted successfully!');
    }

}
