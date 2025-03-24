<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CompanyFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id = $this -> company ?-> id;
            return [
                'code'       => [ 'required', 'string', 'unique:companies,code,' . $id ],
                'title'      => [ 'required', 'string' ],
                'landline'   => [ 'nullable', 'string' ],
                'mobile'     => [ 'nullable', 'string' ],
                'address'    => [ 'nullable', 'string' ],
            ];
        }
    }
