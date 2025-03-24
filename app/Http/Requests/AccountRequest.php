<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class AccountRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $account = $this -> account ? $this -> account -> id : null;
            return [
                'account-head-id' => [
                    'nullable',
                    'numeric',
                    'exists:account_heads,id'
                ],
                'account-type-id' => [
                    'nullable',
                    'numeric',
                    'exists:account_types,id'
                ],
                'name'            => [
                    'required',
                    'string',
                    'unique:account_heads,name,' . $account
                ],
                'phone'           => [
                    'nullable',
                    'string',
                    'max:20'
                ],
                ''
            ];
        }
    }
