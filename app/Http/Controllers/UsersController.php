<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Notifications\RegistrationSuccessful;
use Illuminate\Support\Facades\Hash;

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
            'Fname' => $validatedData['firstname'],
            'Lname' => $validatedData['lastname'],
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

    public function getUserById(Request $request)
    {
        //  print_r($request->id);
        $user = User::find($request->id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['user' => $user]);
    }

    // public function update(Request $request)
    // {
    //     // $firstname = $request->input('formData');
    //     $formData = [];
    //     parse_str($request->input('formData'), $formData);

    //     // Access individual form fields
    //     $firstName = $formData['firstname'];
    //     // $lastName = $formData['lastname'];
    //     // dd($firstName, "djfghdj");

    //     $user = User::find($request->id);
    //     if (!$user) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }

    //     $validatedData = $request->validate([
    //         'firstname' => 'required',
    //         'lastname' => 'required',
    //         'phone' => 'required',
    //         'city' => 'required',
    //         'state' => 'required',
    //         'zip' => 'required',
    //         'address' => 'required',
    //         'email' => 'required|email',
    //     ]);
    //     // Update the user data
    //     $user->update([
    //         'Fname' => $validatedData['firstname'],
    //         'Lname' => $validatedData['lastname'],
    //         'phone' => $validatedData['phone'],
    //         'city' => $validatedData['city'],
    //         'state' => $validatedData['state'],
    //         'zipcode' => $validatedData['zip'],
    //         'address' => $validatedData['address'],
    //         'email' => $validatedData['email'],
    //     ]);

    //     return response()->json(["status" => 1 ,'success' => 'User data updated successfully']);
    // }

    public function destroy(Request $request)
    {

        $user = User::find($request->id);

        if ($user) {
            $user->delete();
            return response()->json(['success' => 'User deleted successfully']);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }


    public function changePassword(Request $request)
    {
        $id = ($request->user_id);
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        $data = array(
            "password" => Hash::make($request->password)
        );
        // Update the user's password
        User::where('id', $id)->update($data);
        return redirect()->back()->with('success', 'Password changed successfully');
    }
}
