<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class AddOpeningBalanceRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            return [
                'account-head-id'  => [
                    'required',
                    'exists:account_heads,id'
                ],
                'transaction-type' => [
                    'required'
                ],
                'amount'           => [
                    'required',
                    'numeric',
                    'min:0'
                ],
                'transaction-date' => [
                    'required',
                    'date'
                ],
            ];
        }
    }
