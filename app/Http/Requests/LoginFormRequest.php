<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class LoginFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            return [
                'email'    => [
                    'required',
                    'email',
                    'exists:users,email'
                ],
                'password' => [
                    'required',
                    'string',
                    'min:3',
                ]
            ];
        }
        
        public function messages (): array {
            return [
                'email.exists' => 'Email does not exists.',
                'password.min' => 'Password should be at least 3 characters long.',
            ];
        }
    }
