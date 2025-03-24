<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class ReferralFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id = $this -> referral ? $this -> referral -> id : null;
            return [
                'title'          => [ 'required', 'string', 'unique:referrals,name,' . $id ],
                'contact'        => [ 'nullable', 'string' ],
                'address'        => [ 'nullable', 'string' ],
            ];
        }
    }
