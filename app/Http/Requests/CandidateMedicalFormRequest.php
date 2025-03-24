<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CandidateMedicalFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $medical_id = $this -> medical ? $this -> medical -> id : null;
            return [
                'payment-method' => [ 'sometimes', 'numeric', 'exists:payment_methods,id' ],
                'vendor-id'      => [ 'sometimes', 'numeric', 'exists:vendors,id' ],
                'transaction-no' => [ 'required', 'string', 'unique:candidate_medicals,transaction_no,' . $medical_id ],
                'status'         => [ 'nullable', 'string' ],
            ];
        }
    }
