<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class ProvinceFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id = $this -> province ? $this -> province -> id : null;
            
            return [
                'title' => [ 'required', 'string', 'min:3', 'unique:provinces,title,' . $id ]
            ];
        }
    }
