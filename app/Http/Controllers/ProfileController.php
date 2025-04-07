<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'bio' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:100',
            'organization' => 'nullable|string|max:100',
            'education' => 'nullable|string|max:100',
            'languages' => 'nullable|string|max:100',
            'volunteer_reason' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_relationship' => 'nullable|string|max:50',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_email' => 'nullable|string|email|max:100',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Handle profile image upload if provided
        if ($request->hasFile('profile_image')) {
            $imageName = time() . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('images/profiles'), $imageName);
            $user->profile_image = 'images/profiles/' . $imageName;
        }

        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->about = $request->about;
        $user->city = $request->city;
        $user->phone = $request->phone;
        $user->occupation = $request->occupation;
        $user->organization = $request->organization;
        $user->education = $request->education;
        $user->languages = $request->languages;
        $user->volunteer_reason = $request->volunteer_reason;
        $user->emergency_contact_name = $request->emergency_contact_name;
        $user->emergency_contact_relationship = $request->emergency_contact_relationship;
        $user->emergency_contact_phone = $request->emergency_contact_phone;
        $user->emergency_contact_email = $request->emergency_contact_email;

        // Check if email was changed and reset verification timestamp
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
    }

    /**
     * Update the user's profile information with ProfileUpdateRequest.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
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