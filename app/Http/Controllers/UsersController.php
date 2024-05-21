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
        // Validate the incoming request data
        $validatedData = $request->validated();

        // Check if the email already exists in the database
        if (User::where('email', $validatedData['email'])->exists()) {
            return back()->withErrors(['email' => 'Email already exists'])->withInput();
        }

        // Create a new user record
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

        // Retrieve the newly created user
        $user = User::where('email', $validatedData['email'])->first();

        // Prepare notification messages
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

        // Send registration successful notification
        $user->notify(new RegistrationSuccessful($messages));

        return redirect()->route('login')->with('success', 'Registration successful!');
    }
    public function showListing()
{
    // Retrieve all users
    $users = User::all();
    return view('Users.listing', compact('users'));
}
}

