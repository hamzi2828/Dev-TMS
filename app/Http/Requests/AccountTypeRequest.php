<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class AccountTypeRequest extends FormRequest {
        
        public function authorize () {
            return true;
        }
        
        public function rules () {
            $account_type = $this -> account_type ? $this -> account_type -> id : null;
            
            return [
                'title' => [
                    'required',
                    'string',
                    'unique:account_types,title,' . $account_type
                ]
            ];
        }
    }
