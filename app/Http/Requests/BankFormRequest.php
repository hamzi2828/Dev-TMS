<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class BankFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $bank_id = $this -> bank ? $this -> bank -> id : null;
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:banks,title,' . $bank_id
                ]
            ];
        }
    }
