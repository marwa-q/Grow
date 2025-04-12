<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Activity;
use App\Models\Post;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the profile page for the current user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get current user data
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function show($id = null)
    {
        // Get the user (either the requested user or the authenticated user)
        $user = $id ? User::findOrFail($id) : auth()->user();

        // Get activity count
        $activityCount = Activity::where('user_id', $user->id)->count();

        // Get posts count
        $postCount = Post::where('user_id', $user->id)->count();

        return view('profile.show', compact(
            'user',
            'activityCount',
            'totalHours',
            'postCount'
        ));
    }

    public function profile()
    {
        $user = auth()->user();

        // Get recent activities for the user, limit to 3 for the profile page
        $activities = Activity::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->take(3)
            ->get();

        // Get posts with comment counts
        $posts = Post::where('user_id', $user->id)
            ->withCount(['likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('profile.show', compact('user', 'activities', 'posts'));
    }



    /**
     * Show the profile edit form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        $user = Auth::user();
        $updateMessage = 'Profile updated successfully';
        $hasProfileImageUpdate = false;
        $hasPasswordUpdate = false;
    
        // Handle profile image upload if provided
        if ($request->hasFile('profile_image')) {
            $imageName = time() . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('images/profiles'), $imageName);
            $user->profile_image = 'images/profiles/' . $imageName;
            $hasProfileImageUpdate = true;
        }
    
        // Update user data
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
    
        // Handle password change if provided
        if ($request->filled('password')) {
            // Check if the current password field was provided
            if (!$request->filled('current_password')) {
                return back()->withErrors([
                    'current_password' => 'Current password is required to change your password.',
                ])->withInput();
            }
            
            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The provided password does not match your current password.',
                ])->withInput();
            }
    
            $user->password = Hash::make($request->password);
            $hasPasswordUpdate = true;
        }
    
        // Check if email was changed and reset verification timestamp
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        $user->save();
    
        // Customize success message based on what was updated
        if ($hasPasswordUpdate && $hasProfileImageUpdate) {
            $updateMessage = 'Profile and password updated successfully';
        } elseif ($hasPasswordUpdate) {
            $updateMessage = 'Password updated successfully';
        } elseif ($hasProfileImageUpdate) {
            $updateMessage = 'Profile image updated successfully';
        }
    
        return redirect()->back()->with('success', $updateMessage);
    }

    /**
     * Update the user's profile information with ProfileUpdateRequest.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */


    /**
     * Get profile image HTML with initials fallback
     * 
     * @param \App\Models\User $user
     * @param int $size Size in pixels
     * @return string HTML for the profile image
     */
   



    public function updateWithRequest(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}