<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CandidateCompanyRequisitionJobFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            return [
                'company-requisition-job-id' => [ 'required', 'numeric', 'exists:company_requisition_jobs,id' ]
            ];
        }
    }
