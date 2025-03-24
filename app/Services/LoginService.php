<?php
    
    namespace App\Services;
    
    use Illuminate\Support\Facades\Auth;
    
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
        
    }