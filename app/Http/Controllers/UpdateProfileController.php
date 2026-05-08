<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\candidate;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Models\candidate_coalition;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UpdateProfileController extends Controller
{
    //
    
    public function index(){
        return view('livewire.admin.update-profile');
    }
    public function candidate(){
        return view('livewire.candidates.update-profile');
    }

    public function UpdateEmailView(){

        return view('livewire.admin.update-emails');
    }

    public function search(Request $request)
{
    $request->validate([
        'school_id' => 'required'
    ]);

    $student = User::where('school_id', $request->school_id)->first();

    if (!$student) {
        return redirect()->route('/update-email')->with('status', [
            'type' => 'error',
            'message' => 'No student found with that ID'
        ]);
    }

    // Flash data to next request
    return redirect()->route('students.email-update')->with('student', $student);
}
    
    
    
    public function showEmailUpdateForm(Request $request)
    {
        $student = session('student'); // Flash session from search
        return view('livewire.admin.update-emails', compact('student'));
    }

    public function updateEmail(Request $request, $id)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $student = User::findOrFail($id);
    $student->email = $request->email;
    $student->save();

    return redirect()->route('/update-email')->with('status', [
        'type' => 'success',
        'message' => 'Email updated successfully'
    ]);
}



   

    public function updateCandidate(Request $request)
{
    // Validate the incoming data
    $validated = $request->validate([
        'password' => 'nullable|string|min:8|confirmed',
        'biography' => 'nullable|string|max:500',
        'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // For profile image
    ]);

    // Get the current candidate using the 'candidates' guard
    $candidate = Auth::guard('candidates')->user();

   

    // Handle password change if provided
    if ($request->filled('password')) {
        $candidate->password = bcrypt($validated['password']);
    }

    $candidate->biography = $validated['biography'];

    // If a new profile image is uploaded, store it in the 'candidates' subdirectory
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($candidate->image && Storage::disk('public')->exists($candidate->image)) {
            Storage::disk('public')->delete($candidate->image);
        }

        // Store the new image in the 'candidates' subdirectory
        $imagePath = $request->file('image')->store('candidate', 'public');
        $candidate->image = $imagePath;
    }

    // Save the updated candidate data
    $candidate->save();

    // Log the activity
    $this->logUserActivity($candidate, 'Update Profile', 'Candidate updated profile successfully!');

    // Redirect back with success message
    return redirect()->route('/camp')->with('success', 'Profile updated successfully!');
}

    public function update(Request $request)
    {
        // Validate the incoming data
        
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'bio' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // For profile image
        ]);
      
        // Get the current user
        $user = Auth::user();
        
        // Update user data
        $user->firstName = $validated['firstName'];
        $user->lastName = $validated['lastName'];
        $user->email = $validated['email'];
        
        // Handle password change if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }

        $user->phone = $validated['phone'];
        $user->bio = $validated['bio'];
        
        // If a new profile image is uploaded, store it
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $user->image = $imagePath;
        }
        
        
        
        // Save the updated user data
        $user->save();
        $this->logUserActivity($user, 'Update Profile', 'User updated profile successfully!');
        // Redirect back with success message
        return redirect()->route('/update-profile')->with('success', 'Profile updated successfully!');
    }


    protected function logUserActivity($user, string $action, string $details)
    {
        if ($user instanceof User || $user instanceof candidate_coalition) {
            Log::info('Logging activity for user:', [
                'user_id' => $user->id,
                'school_id' => $user->school_id,
                'action' => $action,
                'details' => $details,
            ]);
    
            UserActivity::create([
                'session_id' => session()->getId(),
                'user_id' => $user instanceof User ? $user->id : null, // Set user_id to NULL for candidates
                'school_id' => $user->school_id,
                'action' => $action,
                'details' => $details,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } else {
            Log::error("Invalid user type provided to logUserActivity.");
        }
    }

}
