<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class LeadSourceFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $lead_source_id = $this -> lead_source ? $this -> lead_source -> id : null;
            
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:lead_sources,title,' . $lead_source_id
                ]
            ];
        }
    }
