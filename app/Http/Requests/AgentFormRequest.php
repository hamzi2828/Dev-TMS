<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class AgentFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id = $this -> agent ? $this -> agent -> id : null;
            return [
                'title'          => [ 'required', 'string', 'unique:agents,name,' . $id ],
                'contact'        => [ 'nullable', 'string' ],
                'address'        => [ 'nullable', 'string' ],
            ];
        }
    }
