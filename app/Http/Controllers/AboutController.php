<?php

namespace App\Http\Controllers;
use App\Models\ActivityUser;

use App\Models\User;


class AboutController extends Controller
{
    public function index()
    {
        // جلب جميع المستخدمين
        $users = User::all();
        
        // جلب جميع المتطوعين مع النشاطات المرتبطة
        $volunteers = ActivityUser::with('user', 'activity')->get();
    
        // يمكن إضافة المزيد من البيانات للصفحة (اختياري)
       
        return view('about.about', compact('users'));
    }

    public function getVolunteers()
{
    $volunteers = ActivityUser::with('user', 'activity')->get();
    return response()->json($volunteers);
}

}    