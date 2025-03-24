<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class PrincipalFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id = $this -> principal ? $this -> principal -> id : null;
            return [
                'title'          => [ 'required', 'string', 'unique:principals,name,' . $id ],
                'contact'        => [ 'nullable', 'string' ],
                'address'        => [ 'nullable', 'string' ],
            ];
        }
    }
