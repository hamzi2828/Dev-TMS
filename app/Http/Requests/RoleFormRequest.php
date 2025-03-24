<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class RoleFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id = $this -> role ? $this -> role -> id : null;
            return [
                'title' => [ 'required', 'string', 'unique:roles,title,' . $id ]
            ];
        }
    }
