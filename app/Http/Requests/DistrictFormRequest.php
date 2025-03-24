<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class DistrictFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id = $this -> district ? $this -> district -> id : null;
            
            return [
                'title' => [ 'required', 'string', 'min:3', 'unique:districts,title,' . $id ]
            ];
        }
    }
