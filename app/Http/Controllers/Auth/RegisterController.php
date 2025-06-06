<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GoogleAccount;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use MailerLite\MailerLite;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $baseSlug = Str::slug($data['first_name'] . '' . $data['last_name']);
        $slug = $baseSlug;
        $count = 1;

        // Ensure user slug is unique
        while (\App\Models\User::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }
        $user = User::create([
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'slug' => $slug,
//            role 0 = pending, role 1 = practitioner, role 2 = Admin
            'role' => 1,
            //  default status  0 = Inactive, status 1 = Active, status 2 = pending,
            'status' => 2,
            'password' => Hash::make($data['password']),
        ]);

        UserDetail::create([
            'user_id' => $user->id,
            'slug' => $slug,
            'bio' => $data['bio'] ?? null,
            'location' => $data['location'] ?? null,
            'tags' => isset($data['tags']) ? json_encode($data['tags']) : json_encode([]),
            'images' => isset($data['images']) ? json_encode($data['images']) : json_encode([]),
            'seeking_for' => isset($data['seeking_for']) ? json_encode($data['seeking_for']) : json_encode([]),
            'about_me' => $data['about_me'] ?? null,
            'help' => $data['help'] ?? null,
            'specialities' => $data['specialities'] ?? null,
            'certifications' => $data['certifications'] ?? null,
            'endorsements' => $data['endorsements'] ?? null,
            'timezone' => $data['timezone'] ?? null,
            'is_opening_hours' => $data['is_opening_hours'] ?? false,
            'is_notice' => $data['is_notice'] ?? false,
            'is_google_analytics' => $data['is_google_analytics'] ?? false,
            'privacy_policy' => $data['privacy_policy'] ?? null,
            'terms_condition' => $data['terms_condition'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ]);

        GoogleAccount::create([
                'user_id' => $user->id,
            ]
        );
        $mailerLite = new MailerLite(['api_key' => env("MAILERLITE_KEY")]);
        $data = [
            'email' => $data['email'],
            "fields" => [
                "name" => $data['first_name'],
                "last_name" => $data['last_name']
            ],
            'groups' => [
                env('MAILERLITE_PRACTITIONER_GROUP')
            ]
        ];
        $mailerLite->subscribers->create($data);
        return $user;
    }



}
