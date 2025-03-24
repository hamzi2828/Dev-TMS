<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;
    
    class AgreementFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $principalId = $this -> input ( 'principal-id' );
            $id          = $this -> agreement ? $this -> agreement -> id : null;
            return [
                'job-id'       => [ 'required', 'numeric', 'exists:jobs,id',
                                    Rule ::unique ( 'agreements', 'job_id' ) -> where ( function ( $query ) use ( $principalId ) {
                                        $query -> where ( 'principal_id', $principalId );
                                    } ) -> ignore ( $id ),
                ],
                'principal-id' => [ 'required', 'numeric', 'exists:principals,id' ],
                'title'        => [ 'required', 'string' ],
                'template'     => [ 'required' ],
            ];
        }
        
        public function messages (): array {
            return [
                'job-id.unique' => 'A profession already exists for the specified principal.',
            ];
        }
    }
