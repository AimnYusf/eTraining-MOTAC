<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException; // Add this line

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Define validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        // Define custom messages for validation
        $messages = [
            'name.required' => 'Ruangan Nama wajib diisi.',
            'name.string' => 'Nama mesti berupa teks.',
            'name.max' => 'Nama tidak boleh melebihi 255 aksara.',
            'email.required' => 'Ruangan Emel wajib diisi.',
            'email.string' => 'Emel mesti berupa teks.',
            'email.lowercase' => 'Emel mesti dalam huruf kecil.',
            'email.email' => 'Emel mesti alamat emel yang sah.',
            'email.max' => 'Emel tidak boleh melebihi 255 aksara.',
            'email.unique' => 'Emel ini sudah wujud.',
            'password.required' => 'Ruangan Kata Laluan wajib diisi.',
            'password.confirmed' => 'Pengesahan Kata Laluan tidak sepadan.',
            'password' => 'Pastikan kata laluan mengandungi sekurang-kurangnya 8 aksara.',
        ];

        try {
            $request->validate($rules, $messages);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guest',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
