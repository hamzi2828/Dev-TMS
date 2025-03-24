<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class DataBankFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            return [
                'referral-id'          => [ 'sometimes', 'numeric', 'exists:referrals,id' ],
                'job-id'               => [ 'required', 'numeric', 'exists:jobs,id' ],
                'country-id'           => [ 'nullable', 'numeric', 'exists:countries,id' ],
                'issue-country-id'     => [ 'nullable', 'numeric', 'exists:countries,id' ],
                'city-id'              => [ 'nullable', 'numeric', 'exists:cities,id' ],
                'qualification-id'     => [ 'nullable', 'numeric', 'exists:qualifications,id' ],
                'lead-source-id'       => [ 'nullable', 'numeric', 'exists:lead_sources,id' ],
                'province-id'          => [ 'nullable', 'numeric', 'exists:provinces,id' ],
                'district-id'          => [ 'nullable', 'numeric', 'exists:districts,id' ],
                'first-name'           => [ 'required', 'string' ],
                'last-name'            => [ 'required', 'string' ],
                'father-name'          => [ 'nullable', 'string' ],
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
            ];
        }
    }
