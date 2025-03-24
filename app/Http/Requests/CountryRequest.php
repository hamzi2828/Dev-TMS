<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CountryRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            
            $country_id = $this -> country ? $this -> country -> id : null;
            
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:countries,title,' . $country_id
                ]
            ];
        }
        
        public function messages (): array {
            return [
                'title.unique' => 'Country name already exists.'
            ];
        }
    }
