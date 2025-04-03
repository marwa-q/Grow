<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Donation;
class ActivityController extends Controller
{
    
    public function index($categoryId = null)
    {
        $categories = Category::all();

        if ($categoryId) {
            $selectedCategory = Category::find($categoryId);
            if ($selectedCategory) {
                $activitiesByCategory = [
                    $selectedCategory->id => [
                        'name' => $selectedCategory->name,
                        'activities' => Activity::where('category_id', $categoryId)->get()
                    ]
                ];
            } else {
       
                return redirect()->route('activities.index');
            }
        } else {
       
            $activitiesByCategory = [];
            
            foreach ($categories as $category) {
                $activities = Activity::where('category_id', $category->id)->get();
                
              
                if ($activities->count() > 0) {
                    $activitiesByCategory[$category->id] = [
                        'name' => $category->name,
                        'activities' => $activities
                    ];
                }
            }
        }

        return view('activities.index', compact('activitiesByCategory', 'categories'));
    }

 
    public function joinActivity(Request $request, $activityId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must log in first.');
        }

        $user = Auth::user();
        $activity = Activity::find($activityId);

        if (!$activity) {
            return back()->with('error', 'Activity not found.');
        }


        if ($activity->participants()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'You are already participating in this activity!');
        }


        $activity->participants()->attach($user->id, ['joined_at' => now()]);

        
        return back()->with('success', 'Activity joined successfully!');
    }


    public function leaveActivity(Request $request, $activityId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must log in first.');
        }

        $activity = Activity::find($activityId);

        if (!$activity) {
            return back()->with('error', 'Activity not found.');
        }

        
        if ($activity->participants->contains(Auth::user()->id)) {
            
            $activity->participants()->detach(Auth::user()->id);

            // رسالة نجاح
            return back()->with('success', 'Subscription successfully unsubscribed.');
        }

        return back()->with('error', 'You are not participating in this activity.');
    }
    public function donate(Request $request)
    {
        // التحقق من صحة المدخلات
        $request->validate([
            'activity_id' => 'required|exists:activities,id',  // تحقق من وجود النشاط
            'amount' => 'required|numeric|min:1',  // تحقق من أن المبلغ رقمي وأكبر من 1
        ]);
    
        // إذا أردت السماح بالتبرع بنفس النشاط مرة أخرى، لا تحقق من التبرع السابق
        // ويمكنك إضافة شرط خاص إذا أردت السماح فقط بعد مرور وقت معين أو بناءً على شروط أخرى.
    
        // إضافة التبرع
        Donation::create([
            'user_id' => Auth::id(),
            'activity_id' => $request->activity_id,
            'amount' => $request->amount,
            'donated_at' => now(),  // تأكد من استخدام "donated_at"
        ]);
    
        // إعادة توجيه مع رسالة النجاح
        return redirect()->back()->with('success', 'تمت إضافة التبرع بنجاح!');
    }

}