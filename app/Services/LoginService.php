<?php

    namespace App\Services;

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;

    use App\Models\User;

class LoginService {

        public function login ( $request ) {
            $credentials = array (
                'email'    => $request -> input ( 'email' ),
                'password' => $request -> input ( 'password' ),
                'active'   => '1'
            );

            $remember = $request -> input ( 'remember-me' );
            if ( isset( $remember ) and $remember == '1' )
                $remember = true;
            else
                $remember = false;

            if ( Auth ::attempt ( $credentials, $remember ) ) {
                $request -> session () -> regenerate ();
                return auth () -> user () -> id;
            }
            else
                return false;
        }

        public function register($request)
        {
            $user = User::create([
                'name' => $request->input('full_name'),
                'company_name' => $request->input('company_name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile_number'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
                'password' => Hash::make($request->input('password')),
            ]);
            return $user ? $user->id : 0;
        }

    }
