<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class VendorFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id = $this -> vendor ? $this -> vendor -> id : null;
            return [
                'title'          => [ 'required', 'string', 'unique:vendors,title,' . $id ],
                'contact'        => [ 'nullable', 'string' ],
                'address'        => [ 'nullable', 'string' ],
                'fee'            => [ 'required', 'numeric' ],
                'vendor-payable' => [ 'required', 'numeric' ],
            ];
        }
    }
