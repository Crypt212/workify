<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SeekerProfileController 
{
    public function showByEmail($email)
    {
        // جلب المستخدم بناء على الإيميل أو يرمي 404 لو مش موجود
        $user = User::where('email', $email)->firstOrFail();

        // جلب بيانات صاحب العمل المرتبط (لو العلاقة موجودة)
        $employer = $user->employer;

        // ترجع صفحة البروفايل مع بيانات صاحب العمل
        return view('seeker.profile', compact('employer'));
    }
}
