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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@(tourism\.gov\.my|kraftangan\.gov\.my|aswara\.edu\.my|artgallery\.gov\.my|motac\.gov\.my|jkkn\.gov\.my|heritage\.gov\.my|matic\.gov\.my|istanabudaya\.gov\.my)$/',
                'unique:' . User::class,
            ],
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:12',
                'regex:/[a-z]/',      // at least one lowercase
                'regex:/[A-Z]/',      // at least one uppercase
                'regex:/[0-9]/',      // at least one number
                'regex:/[\W_]/',      // at least one symbol
            ],
        ];

        $messages = [
            'name.required' => 'Ruangan Nama wajib diisi.',
            'name.string' => 'Nama mesti berupa teks.',
            'name.max' => 'Nama tidak boleh melebihi 255 aksara.',

            'email.required' => 'Ruangan Emel wajib diisi.',
            'email.string' => 'Emel mesti berupa teks.',
            'email.lowercase' => 'Emel mesti dalam huruf kecil.',
            'email.email' => 'Emel mesti alamat emel yang sah.',
            'email.max' => 'Emel tidak boleh melebihi 255 aksara.',
            'email.regex' => 'Emel mesti merupakan emel rasmi Kementerian/Jabatan/Agensi.',
            'email.unique' => 'Emel ini sudah wujud.',

            'password.required' => 'Ruangan Kata Laluan wajib diisi.',
            'password.confirmed' => 'Pengesahan Kata Laluan tidak sepadan.',
            'password.min' => 'Kata Laluan mesti mengandungi sekurang-kurangnya 12 aksara.',
            'password.regex' => 'Kata Laluan mesti mengandungi huruf besar, huruf kecil, nombor dan simbol.',
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
            'role' => '1',
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

}
