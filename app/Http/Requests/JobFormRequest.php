<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class JobFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $job_id = $this -> job ? $this -> job -> id : null;
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:jobs,title,' . $job_id
                ],
                'fee' => [ 'required', 'numeric', 'min:0' ],
            ];
        }
    }
