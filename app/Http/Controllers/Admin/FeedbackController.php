<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Offering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $feedbacks = Feedback::with(['admin', 'user', 'offering'])->paginate(10);

        $users = User::where('status', 1)->where('role', 1)->get();

        return view('admin.feedback.index', compact('feedbacks', 'users','user'));
    }

    /**
     * Show the form for creating a new feedback.
     */
    public function create()
    {
        $user = Auth::user();

        $users = User::where('status', 1)->where('role', 1)->get();

        return view('admin.feedback.create', compact('users','user'));
    }

    /**
     * Store newly created feedback in the database.
     */
    public function store(Request $request)
    {

        $request->validate([
            'practitioner_id' => 'nullable|exists:users,id',
            'offering_id' => 'nullable|exists:offerings,id',
            'comment' => 'required|string|max:500',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $data = [
            'admin_id' => auth()->id(), // Storing admin who created the feedback
            'practitioner_id' => $request->practitioner_id,
            'offering_id' => $request->offering_id,
            'comment' => $request->comment,
            'name' => $request->name,
            'rating' => $request->rating,
            'feedback_type' => $request->feedback_type == 'practitioner' ? 'practitioner' : 'offering',
        ];

        // Handle file upload if provided
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            if($request->feedback_type !== 'offering')
            {
                $file->move(public_path('uploads/practitioners/' . $request->practitioner_id . '/feedback/profile/'), $fileName);
            }else{
                $file->move(public_path('uploads/practitioners/' . $request->practitioner_id . '/feedback/offering/'), $fileName);
            }

            $data['image'] = $fileName;
        }

        Feedback::create($data);

        return redirect()->route('admin.feedback.index')->with('success', 'Feedback added successfully.');
    }

    /**
     * Show the form for editing the specified feedback.
     */
    public function edit(Feedback $feedback)
    {
        $user = Auth::user();

        $users = User::where('status', 1)->where('role', 1)->get();

        $offerings = Offering::where('user_id', $feedback->practitioner_id)->get();

        return view('admin.feedback.edit', compact('feedback', 'users', 'offerings','user'));
    }

    /**
     * Update the specified feedback in the database.
     */
    public function update(Request $request, Feedback $feedback)
    {

        $request->validate([
            'practitioner_id' => 'nullable|exists:users,id',
            'offering_id' => 'nullable|exists:offerings,id',
            'comment' => 'required|string|max:500',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $data = [
            'admin_id' => auth()->id(), // Storing admin who created the feedback
            'practitioner_id' => $request->practitioner_id,
            'offering_id' => $request->offering_id,
            'comment' => $request->comment,
            'name' => $request->name,
            'rating' => $request->rating,
            'feedback_type' => $request->feedback_type == 'practitioner' ? 'practitioner' : 'offering',
        ];

        // Handle file upload if provided
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            if($request->feedback_type !== 'offering')
            {
                $file->move(public_path('uploads/practitioners/' . $request->practitioner_id . '/feedback/profile/'), $fileName);
            }else{
                $file->move(public_path('uploads/practitioners/' . $request->practitioner_id . '/feedback/offering/'), $fileName);
            }

            $data['image'] = $fileName;
        }

        $feedback->update($data);

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
    public function getOfferingsByUser(Request $request, $userId)
    {

        $offerings = Offering::where('user_id', $userId)->get();

        return response()->json($offerings);
    }
}

