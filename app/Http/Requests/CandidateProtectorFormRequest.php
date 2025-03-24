<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CandidateProtectorFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            return [
                'reg-no'         => [ 'nullable', 'string' ],
                'protector-date' => [ 'nullable', 'date' ],
                'status'         => [ 'nullable', 'string' ],
            ];
        }
    }
