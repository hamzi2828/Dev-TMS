<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CompanyRequisitionFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            return [
                'principal-id' => [ 'required', 'numeric', 'exists:principals,id' ]
            ];
        }
    }
