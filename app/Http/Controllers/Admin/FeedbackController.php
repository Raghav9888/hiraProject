<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Offering;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with(['admin', 'user', 'offering'])->paginate(10);
        $users = User::all(); // Fetching users
        return view('admin.feedback.index', compact('feedbacks', 'users'));
    }

    /**
     * Show the form for creating a new feedback.
     */
    public function create()
    {
        $users = User::where('role', 1)->get(); // Fetching practitioners
        return view('admin.feedback.create', compact('users'));
    }

    /**
     * Store newly created feedback in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'offering_id' => 'nullable|exists:offerings,id',
            'comment' => 'required|string|max:500',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        Feedback::create([
            'admin_id' => auth()->id(), // Storing admin who created the feedback
            'user_id' => $request->user_id,
            'offering_id' => $request->offering_id,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return redirect()->route('admin.feedback.index')->with('success', 'Feedback added successfully.');
    }

    /**
     * Show the form for editing the specified feedback.
     */
    public function edit(Feedback $feedback)
    {
        $users = User::all();
        $offerings = Offering::where('user_id', $feedback->user_id)->get();
        return view('admin.feedback.edit', compact('feedback', 'users', 'offerings'));
    }

    /**
     * Update the specified feedback in the database.
     */
    public function update(Request $request, Feedback $feedback)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'offering_id' => 'nullable|exists:offerings,id',
            'comment' => 'required|string|max:500',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $feedback->update([
            'user_id' => $request->user_id,
            'offering_id' => $request->offering_id,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return redirect()->route('admin.feedback.index')->with('success', 'Feedback updated successfully.');
    }

    /**
     * Remove the specified feedback from the database.
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('admin.feedback.index')->with('success', 'Feedback deleted successfully.');
    }

    /**
     * Fetch offerings dynamically based on selected user (AJAX request).
     */
    public function getOfferingsByUser(Request $request,$userId)
    {

        $offerings = Offering::where('user_id', $userId)->get();

        return response()->json($offerings);
    }
}

