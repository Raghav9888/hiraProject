<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use App\Models\WordpressUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
                    'password' => Hash::make('123456'),
                    'role' => 1,
                ]);
            }

            // Ensure UserDetail exists for this user
            UserDetail::firstOrCreate(
                ['user_id' => $user->id],
                ['email' => $wpUser->user_email] // Additional data
            );
        }

        return response()->json(['message' => 'Users imported successfully']);
    }

}
