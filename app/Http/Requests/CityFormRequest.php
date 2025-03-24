<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CityFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $city_id = $this -> city ? $this -> city -> id : null;
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:cities,title,' . $city_id
                ]
            ];
        }
    }
