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
            
            // Calculate post count for stats display
            $postCount = Post::where('user_id', $user->id)->count();
            
            // Calculate activity count for stats display
            $activityCount = Activity::where('user_id', $user->id)->count();
            
            // Add additional counts for joined activities if needed
            $joinedActivitiesCount = $user->joinedActivities()->count();
            $activityCount += $joinedActivitiesCount;
            
            return view('profile.show', compact('user', 'activities', 'posts', 'postCount', 'activityCount'));
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
                'phone' => 'nullable|string|max:20',
                'bio' => 'nullable|string|max:1000', // Add this line
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
            $user->phone = $request->phone;
            $user->bio = $request->bio; // Add this line

            // Save the updated user data
            $user->save();

            // Check if password update was requested
            if ($request->filled('password')) {
                // Verify the current password
                if (!Hash::check($request->current_password, $user->password)) {
                    return redirect()->back()->with('error', 'Current password is incorrect');
                }

                // Update the password
                $user->password = Hash::make($request->password);
                $user->save();
                $hasPasswordUpdate = true;
            }

            // Build success message
            if ($hasProfileImageUpdate && $hasPasswordUpdate) {
                $updateMessage = 'Profile and password updated successfully';
            } elseif ($hasProfileImageUpdate) {
                $updateMessage = 'Profile updated successfully';
            } elseif ($hasPasswordUpdate) {
                $updateMessage = 'Password updated successfully';
            }

            return redirect()->route('profile.edit')->with('success', $updateMessage);
        }



        // ProfileController.php
        public function updateEmail(Request $request)
        {
            $request->validate([
                'password' => 'required',
                'new_email' => 'required|email|unique:users,email,' . auth()->id(),
            ]);

            $user = auth()->user();

            // Verify password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'error' => 'The provided password does not match your current password.'
                ]);
            }

            // Update email
            $user->email = $request->new_email;
            $user->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => 'Email address updated successfully!',
                    'email' => $user->email
                ]);
            }

            return redirect()->back()->with('success', 'Email address updated successfully!');
        }


        public function removePhoto()
        {
            $user = Auth::user();

            // Delete the actual file if it exists
            if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }

            // Set the profile_image field to null
            $user->profile_image = null;
            $user->save();

            return redirect()->back()->with('success', 'Profile photo removed successfully');
        }

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