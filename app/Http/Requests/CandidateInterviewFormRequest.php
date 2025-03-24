<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CandidateInterviewFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            return [
                'spoken-english-score' => [ 'nullable', 'string' ],
                'overall-ept'          => [ 'nullable', 'string' ],
                'attitude'             => [ 'nullable', 'string' ],
                'job-experience'       => [ 'nullable', 'string' ],
                'remarks'              => [ 'nullable', 'string' ],
                'status'               => [ 'sometimes', 'string' ],
            ];
        }
    }
