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

            if (!User::where('email', $wpUser->user_email)->exists()) {
dump($wpUser);
//                $user = User::create([
//                    'name' => $wpUser->user_login,
//                    'email' => $wpUser->user_email,
//                    'password' => $this->make($wpUser->user_pass),
//                    'role' => 1,
//                ]);
//
//                UserDetail::create([
//                    'user_id' => $user->id,
//                    'email' => $wpUser->user_email,
//                ]);
            }

        }
        exit();


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
