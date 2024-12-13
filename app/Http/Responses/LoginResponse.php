<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return redirect('/kict-dashboard');
        }

        else if($user->hasRole('advisor')){
            return redirect('/teacher-dashboard');
        }
        return redirect('/student-dashboard'); // Default redirect
    }
}
