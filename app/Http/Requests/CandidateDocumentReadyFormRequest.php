<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CandidateDocumentReadyFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            return [
                'status' => [ 'nullable', 'string' ],
                'reason' => [ 'nullable', 'string' ]
            ];
        }
    }
