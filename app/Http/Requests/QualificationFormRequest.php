<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class QualificationFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $qualification_id = $this -> qualification ? $this -> qualification -> id : null;
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:qualifications,title,' . $qualification_id
                ]
            ];
        }
    }
