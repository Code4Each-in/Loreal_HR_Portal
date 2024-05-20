<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Notifications\RegistrationSuccessful;

class UsersController extends Controller
{
    public function registration()
    {
        return view('Users.register');
    }
    public function register(UserRequest $request)
    {

        $validatedData = $request->validated();
        // dd($validatedData);
        if (User::where('email', $validatedData['email'])->exists()) {
            return back()->withErrors(['email' => 'Email already exists'])->withInput();
        }
        User::create([
            'Fname' => $validatedData['fname'],
            'Lname' => $validatedData['lname'],
            'phone' => $validatedData['phone'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
            'zipcode' => $validatedData['zip'],
            'address' => $validatedData['address'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
        $user = User::where('email', $validatedData['email'])->first();
        $messages = [
            'subject' => 'Welcome to ' . config('app.name'),
            'greeting-text' => 'Dear ' . ucfirst($user->Fname) . ',',
            'lines_array' => [
                'body-text' => 'Thank you for registering with us. Your account has been successfully created.',
                'info' => "You can now log in to your account using the credentials you provided during registration.",
                'additional-info' => 'If you have any questions or need assistance, please feel free to contact us.',
            ],
            'thanks-message' => 'Thank you for choosing our application!',
        ];

        $user->notify(new RegistrationSuccessful($messages));
        return redirect()->route('login')->with('success', 'Registration successful!');
    }
    // public function register(UserRequest $request)
    // {
    //     // Validate the incoming request data
    //     $validator = \Validator::make($request->all(), [
    //         'fname' => 'required|string',
    //         'lname' => 'required|string',
    //         'phone' => 'required|string',
    //         'city' => 'required|string',
    //         'state' => 'required|string',
    //         'zip' => 'required|string',
    //         'address' => 'required|string',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|string|min:6',
    //     ]);


    //     if ($validator->fails()) {
    //         return back()->withErrors($validator)->withInput();
    //     }

    //     User::create([
    //         'Fname' => $request->input('fname'),
    //         'Lname' => $request->input('lname'),
    //         'phone' => $request->input('phone'),
    //         'city' => $request->input('city'),
    //         'state' => $request->input('state'),
    //         'zipcode' => $request->input('zip'),
    //         'address' => $request->input('address'),
    //         'email' => $request->input('email'),
    //         'password' => bcrypt($request->input('password')),
    //     ]);

    //     return redirect()->route('register-user')->with('success', 'Registration successful!');
    // }
}

