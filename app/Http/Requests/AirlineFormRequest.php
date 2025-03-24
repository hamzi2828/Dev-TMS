<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class AirlineFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id = $this -> airline ? $this -> airline -> id : null;
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:airlines,title,' . $id
                ]
            ];
        }
    }
