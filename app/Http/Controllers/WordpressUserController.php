<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use App\Models\WordpressUser;
use App\Models\User;
use Illuminate\Http\Request;

class WordpressUserController extends Controller
{
    public function importUsers()
    {
        $wordpressUsers = WordpressUser::all();

        foreach ($wordpressUsers as $wpUser) {
            // Check if the user exists
            $user = User::where('email', $wpUser->user_email)->first();

            if (!$user) {
                // Create user if not exists
                $user = User::create([
                    'name' => $wpUser->user_login,
                    'email' => $wpUser->user_email,
                    'password' => $this->make($wpUser->user_pass),
                    'role' => 1,
                ]);
            }

            // Ensure UserDetail exists for this user
            UserDetail::firstOrCreate(
                ['user_id' => $user->id], // Unique constraint
                ['email' => $wpUser->user_email] // Additional data
            );
        }

        return response()->json(['message' => 'Users imported successfully']);
    }


    // Password hashing function (can be adjusted to fit your needs)
    public static function make($password)
    {
        // WordPress password hash function or bcrypt (adjust depending on needs)
        return bcrypt($password);  // This uses Laravel's bcrypt instead of WordPress hash
    }

    // Password check function (if needed for validation)
    public static function check($password, $hash)
    {
        // Check if the password matches the hashed password
        return hash_equals($hash, crypt($password, $hash));
    }
}
