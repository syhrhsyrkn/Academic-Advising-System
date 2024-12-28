<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {

        $user = $request->user();

        if ($user->hasRole('admin')) {
            return redirect('/course');
        } elseif ($user->hasRole('advisor')) {
            return redirect('/advisor/student-list');
        } elseif ($user->hasRole('student')) {
            if ($user->student && $user->student->student_id) {
                return redirect('/student-dashboard');
            } else {
                return redirect('/profile/edit'); 
            }
        }

        return redirect('/login');
    }
}
