<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class UserFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id    = $this -> user ?-> id;
            $rules = [
                'name'       => [ 'required', 'string' ],
                'email'      => [ 'required', 'email', 'unique:users,email,' . $id ],
            ];
            
            if ( empty( $id ) )
                $rules[ 'password' ] = [ 'required', 'string' ];
            
            return $rules;
        }
    }
