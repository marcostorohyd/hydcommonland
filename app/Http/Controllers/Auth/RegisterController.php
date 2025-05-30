<?php

namespace App\Http\Controllers\Auth;

use App\Directory;
use App\Http\Controllers\Controller;
use App\Notifications\NewUser;
use App\Status;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/thanks';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('showThanks');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $data = [
            'countries' => \App\Country::all()->sortBy('name')->pluck('name', 'id'),
            'entities' => \App\Entity::all()->pluck('name', 'id'),
            'sectors' => \App\Sector::all()->pluck('name', 'id'),
        ];

        return view('auth.register', compact('data'));
    }

    /**
     * Show the thanks.
     *
     * @return \Illuminate\Http\Response
     */
    public function showThanks()
    {
        return view('auth.thanks');
    }

    /**
     * Handle a registration request for the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        return $this->registered($request, $this->create($request->all()))
                        ?: redirect($this->redirectPath());

        // Omit send email
        // event(new Registered($user = $this->create($request->all())));

        // Remove autologin
        // $this->guard()->login($user);

        // return $this->registered($request, $user)
        //                 ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            // for login
            'email' => 'required|string|email|max:150|unique:users,email,NULL,NULL,deleted_at,NULL',
            'password' => 'required|string|min:6|confirmed',
            // for directory
            'name' => 'required|string|max:180',
            'directory_email' => 'required|string|email|max:180',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:180',
            'zipcode' => 'required|string|max:20',
            'city' => 'required|string|max:80',
            'country_id' => 'required|integer|exists:countries,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'sectors' => 'required|array|exists:sectors,id',
            'entity_id' => 'required|integer|exists:entities,id',
            'contact_name' => 'nullable|string|max:180',
            'contact_email' => 'nullable|string|email|max:180',
            'contact_phone' => 'nullable|string|max:30',
            'partners' => 'nullable|integer|min:1|max:99999999999',
            'members' => 'nullable|integer|min:1|max:99999999999',
            'represented' => 'nullable|integer|min:1|max:99999999999',
            'surface' => 'nullable|integer|min:1|max:99999999999',
            'image' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'vimeo' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|url|max:255',
            'telegram' => 'nullable|url|max:255',
            'research_gate' => 'nullable|url|max:255',
            'orcid' => 'nullable|url|max:255',
            'academia_edu' => 'nullable|url|max:255',
            'web' => 'nullable|url|max:255',
            'terms' => 'required|boolean',
            'accept_lopd' => 'required|boolean',
            'accept_share' => 'required|boolean',
            'accept_advertising' => 'nullable|boolean',
        ];

        if ($data['entity_id'] == \App\Entity::PERSON) {
            $data['contact_name'] = null;
            $data['contact_email'] = null;
            $data['contact_phone'] = null;
        }

        $data['partners'] = in_array($data['entity_id'], [6]) ? $data['partners'] : null;
        $data['members'] = in_array($data['entity_id'], [4, 5, 7]) ? $data['members'] : null;
        $data['represented'] = in_array($data['entity_id'], [8]) ? $data['represented'] : null;
        $data['surface'] = in_array($data['entity_id'], [4, 8]) ? $data['surface'] : null;

        foreach (locales() as $lang) {
            $rules["{$lang}.description"] = 'nullable|required_without_all:'.implode(',', locales_except($lang, '.description')).'|string';
        }

        return Validator::make($data, $rules, [
            'accept_lopd.required' => __('Debe aceptar la política de privacidad del formulario de registro.'),
            'accept_share.required' => __('Debe aceptar la política de privacidad general.'),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'accept_lopd' => $data['accept_lopd'],
                'accept_share' => $data['accept_share'],
                'accept_advertising' => $data['accept_advertising'] ?? null,
            ]);

            $filename = null;
            if (! empty($data['image'])) {
                $extension = pathinfo($data['image'], PATHINFO_EXTENSION);
                $filename = 'photo.'.$extension;
            }

            // Directory
            $directory = [
                'user_id' => $user->id,
                'name' => $data['name'],
                'email' => $data['directory_email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'zipcode' => $data['zipcode'],
                'city' => $data['city'],
                'country_id' => $data['country_id'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'entity_id' => $data['entity_id'],
                'contact_name' => $data['contact_name'],
                'contact_email' => $data['contact_email'],
                'contact_phone' => $data['contact_phone'],
                'partners' => $data['partners'],
                'members' => $data['members'],
                'represented' => $data['represented'],
                'surface' => $data['surface'],
                'image' => $filename,
                'status_id' => Status::PENDING,
            ];

            // Locales
            foreach (locales() as $lang) {
                $directory["description:{$lang}"] = $data["{$lang}"]['description'];
            }

            if (empty($directory['description:en'])) {
                if (empty($directory['description:es-ES'])) {
                    $directory['description:en'] = $directory['description:fr'];
                } else {
                    $directory['description:en'] = $directory['description:es-ES'];
                }
            }
            if (empty($directory['description:es-ES'])) {
                $directory['description:es-ES'] = $directory['description:en'];
            }
            if (empty($directory['description:fr'])) {
                $directory['description:fr'] = $directory['description:en'];
            }

            $directory = Directory::create($directory);
            $directory->sectors()->sync($data['sectors']);

            if (! empty($data['image'])) {
                $target = "public/directory/{$directory->id}/photo.{$extension}";
                Storage::move('public/upload/'.basename($data['image']), $target);
            }

            DB::commit();

            if ($admins = User::admin()->get()) {
                foreach ($admins as $admin) {
                    try {
                        $admin->notify(new NewUser($user));
                    } catch (\Throwable $th) {
                        // pass
                    }
                }
            }

            return $user;
        });
    }
}
