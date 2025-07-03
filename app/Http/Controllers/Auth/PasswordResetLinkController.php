<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException; // Add this line

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     // Set validation rules
    //     $rules = [
    //         'email' => ['required', 'email'],
    //     ];

    //     // Set custom messages for validation
    //     $messages = [
    //         'email.required' => 'Ruangan Emel wajib diisi.',
    //         'email.email' => 'Emel mesti alamat emel yang sah.',
    //     ];

    //     try {
    //         $request->validate($rules, $messages);
    //     } catch (ValidationException $e) {
    //         return redirect()->back()->withErrors($e->errors())->withInput();
    //     }

    //     // Attempt to send the password reset link
    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );

    //     // Respond based on the result of the reset link sending attempt
    //     if ($status === Password::RESET_LINK_SENT) {
    //         return back()->with('status', 'Pautan tetapan semula telah dihantar ke emel anda.');
    //     } else {
    //         return back()
    //             ->withInput($request->only('email'))
    //             ->withErrors(['email' => 'Kami tidak dapat menemui pengguna dengan alamat emel tersebut.']);
    //     }
    // }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Ruangan Emel wajib diisi.',
            'email.email' => 'Emel mesti alamat emel yang sah.',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Kami tidak dapat menemui pengguna dengan alamat emel tersebut.']);
        }

        // Generate password reset token
        $token = app('auth.password.broker')->createToken($user);

        // Build reset URL
        $url = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));

        // Send custom email
        Mail::to($user->email)->send(new ResetPasswordMail($url, $user->name));

        return back()->with('status', 'Pautan tetapan semula telah dihantar ke emel anda.');
    }
}
