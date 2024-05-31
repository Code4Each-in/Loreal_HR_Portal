<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Notifications\RegistrationSuccessful;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;

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
            'role_id' => 2,

        ]);

        // Retrieve the newly created user
        $user = User::where('email', $validatedData['email'])->first();
 
        // Prepare notification messages
        $messages = [
            'subject' => 'Welcome to Local Integration Portal',
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
        Session::flash('message', 'Registration successful! You can now log in.');

        return redirect()->route('login');
    }


    public function showListing()
    {
        // Retrieve all users
        $users = User::with('role')->get();
        $all_roles = Role::all();
        //dump($users); dd();
        return view('Users.listing', compact('users', 'all_roles'));
    }

    //to save new user
    public function saveUser(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create a new User and with validated data
        $user = new User();
        $user->role_id = $validatedData['role_id'];
        $user->Fname = $validatedData['firstname'];
        $user->Lname = $validatedData['lastname'];
        $user->phone = $validatedData['phone'];
        $user->city = $validatedData['city'];
        $user->state = $validatedData['state'];
        $user->zipcode = $validatedData['zip'];
        $user->address = $validatedData['address'];
        $user->email = $validatedData['email'];
        $user->password = $validatedData['password'];

        // Save the user to the database
        $user->save();

        Session::flash('message', 'User saved successfully');
        return response()->json(['success' => 'User saved successfully']);
    }

    public function getUserById(Request $request)
    {
        //  print_r($request->id);
        $user = User::find($request->id);

        if (!$user) {
            return response()->json(['error' => 'User not found']);
        }

        return response()->json(['user' => $user]);
    }

    /**
     *
     */
    public function toggleStatus(Request $request)
    {
        $user = User::find($request->userId);
        $new_status = 0;
        if($request->status == 0){
            $new_status = 1;
        }
            $user->status = $new_status;
            $user->save();
            Session::flash('message', 'User status updated successfully');
            return response()->json(['success' => 'Status updates successfully']);
    }
    /**
     * UPDATE USER DATA
     * @param request
     * @return response
     */
    public function update(Request $request)
    {
        $userToUpdate = User::find($request->edit_form_id);

        if ($userToUpdate) {
            $validatedData = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'phone' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required',
                'address' => 'required',
                'email' => 'required|email|max:255',
                'role_id' => 'required',
            ]);
            //dd($validatedData);

            // Update the user data
            $userToUpdate->where('id',$request->edit_form_id)
                        ->update([
                            'Fname' => $validatedData['firstname'],
                            'Lname' => $validatedData['lastname'],
                            'phone' => $validatedData['phone'],
                            'city' => $validatedData['city'],
                            'state' => $validatedData['state'],
                            'zipcode' => $validatedData['zip'],
                            'address' => $validatedData['address'],
                            'email' => $validatedData['email'],
                            'role_id' => $validatedData['role_id'],
                        ]);
            Session::flash('message', 'User data updated successfully.');
        }
    }

    public function destroy(Request $request)
    {

        $user = User::find($request->id);

        if ($user) {
            $user->delete();
            Session::flash('message', 'User deleted successfully');
        }
    }


    public function changePassword(Request $request)
    {
        $id = ($request->user_id);
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        $data = array(
            "password" => Hash::make($request->password)
        );
        // Update the user's password
        User::where('id', $id)->update($data);
        Session::flash('message', 'Password changed successfully');
    }
}
