<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CandidateFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $candidate_id = $this -> candidate ? $this -> candidate -> id : null;
            return [
                'payment-method'       => [ 'sometimes', 'numeric', 'exists:payment_methods,id' ],
                'transaction-no'       => [ 'sometimes', 'string', 'unique:candidates,transaction_no,' . $candidate_id ],
                'referral-id'          => [ 'sometimes', 'numeric', 'exists:referrals,id' ],
                'job-id'               => [ 'required', 'numeric', 'exists:jobs,id' ],
                'country-id'           => [ 'nullable', 'numeric', 'exists:countries,id' ],
                'issue-country-id'     => [ 'nullable', 'numeric', 'exists:countries,id' ],
                'city-id'              => [ 'nullable', 'numeric', 'exists:cities,id' ],
                'qualification-id'     => [ 'nullable', 'numeric', 'exists:qualifications,id' ],
                'lead-source-id'       => [ 'nullable', 'numeric', 'exists:lead_sources,id' ],
                'bank-id'              => [ 'nullable', 'numeric', 'exists:banks,id' ],
                'province-id'          => [ 'nullable', 'numeric', 'exists:provinces,id' ],
                'district-id'          => [ 'nullable', 'numeric', 'exists:districts,id' ],
                'principal-id'         => [ 'sometimes', 'numeric', 'exists:principals,id' ],
                'first-name'           => [ 'required', 'string' ],
                'last-name'            => [ 'nullable', 'string' ],
                'father-name'          => [ 'required', 'string' ],
                'mother-name'          => [ 'nullable', 'string' ],
                'mobile'               => [ 'required', 'string' ],
                'alt-no'               => [ 'nullable', 'string' ],
                'cnic'                 => [ 'required', 'numeric', 'digits:13' ],
                'dob'                  => [ 'required', 'date' ],
                'cnic-expiry-date'     => [ 'nullable', 'date' ],
                'religion'             => [ 'nullable', 'string' ],
                'marital-status'       => [ 'nullable', 'string' ],
                'age'                  => [ 'nullable', 'numeric' ],
                'gender'               => [ 'nullable', 'string' ],
                'blood-group'          => [ 'nullable', 'string' ],
                'contract-period'      => [ 'nullable', 'numeric' ],
                'accommodation'        => [ 'nullable', 'string' ],
                'food'                 => [ 'nullable', 'string' ],
                'salary'               => [ 'nullable', 'numeric' ],
                'passport'             => [ 'nullable', 'string' ],
                'passport-issue-date'  => [ 'nullable', 'date' ],
                'passport-expiry-date' => [ 'nullable', 'date' ],
                'next-of-kin'          => [ 'nullable', 'string' ],
                'next-of-kin-cnic'     => [ 'nullable', 'numeric' ],
                'kin-relationship'     => [ 'nullable', 'string' ],
                'contact-no'           => [ 'nullable', 'string' ],
                'shirt-size'           => [ 'nullable', 'string' ],
                'trouser-size'         => [ 'nullable', 'string' ],
                'shoes-size'           => [ 'nullable', 'string' ],
                'weight'               => [ 'nullable', 'numeric' ],
                'height'               => [ 'nullable', 'string' ],
                'email'                => [ 'nullable', 'email' ],
                'company-email'        => [ 'nullable', 'email' ],
                'account-no'           => [ 'nullable', 'string' ],
            ];
        }
    }
