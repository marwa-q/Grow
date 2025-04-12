<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share the getProfileImage function with all views
        Blade::directive('edit', function ($expression) {
            return "<?php echo getProfileImage($expression); ?>";
        });
        
        // Define the helper function
        if (!function_exists('getProfileImage')) {
            function getProfileImage($user, $size = 80)
            {
                // Check if user has a profile image
                if ($user->profile_image) {
                    return '<img src="' . asset($user->profile_image) . '" alt="Profile Picture" class="rounded-circle" width="' . $size . '" height="' . $size . '">';
                }
                
                // Generate initials from user's name
                $firstInitial = substr($user->first_name, 0, 1);
                $lastInitial = substr($user->last_name, 0, 1);
                $initials = strtoupper($firstInitial . $lastInitial);
                
                // Generate a unique but consistent color based on the user's ID
                $hue = ($user->id * 137) % 360; // This formula creates a unique hue
                $bgColor = "hsl($hue, 70%, 60%)";
                
                // Create an SVG with the initials
                $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="' . $size . '" height="' . $size . '" class="rounded-circle">' .
                       '<rect width="100" height="100" fill="' . $bgColor . '" />' .
                       '<text x="50" y="50" font-size="40" font-weight="bold" font-family="Arial, sans-serif" fill="white" text-anchor="middle" dominant-baseline="central">' . 
                       $initials . 
                       '</text>' .
                       '</svg>';
                
                return $svg;
            }
        }
    }
}