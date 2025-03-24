<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class PaymentMethodFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $method_id = $this -> payment_method ? $this -> payment_method -> id : null;
            
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:payment_methods,title,' . $method_id
                ]
            ];
        }
    }
