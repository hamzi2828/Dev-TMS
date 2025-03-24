<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateInterview;
    use App\Models\CandidatePaymentFollowUp;
    use App\Models\CandidateTicketFollowUp;
    use App\Models\CandidateVisaFollowUp;
    use App\Models\DataBank;
    use App\Models\Fee;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Facades\DB;
    
    class DataBankService {
        
        public function all (): LengthAwarePaginator {
            $candidates = DataBank ::with ( [ 'job', 'qualification', 'country', 'city', 'source' ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $candidates -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [ $start_date, $end_date ] );
            }
            
            if ( request () -> filled ( 'name' ) ) {
                $candidates -> where ( DB ::raw ( "CONCAT( first_name,  ' ', last_name )" ), 'LIKE', '%' . request ( 'name' ) . '%' );
            }
            
            if ( request () -> filled ( 'mobile' ) )
                $candidates -> where ( [ 'mobile' => request ( 'mobile' ) ] );
            
            if ( request () -> filled ( 'cnic' ) )
                $candidates -> where ( [ 'cnic' => request ( 'cnic' ) ] );
            
            if ( request () -> filled ( 'passport' ) )
                $candidates -> where ( [ 'passport' => request ( 'passport' ) ] );
            
            if ( request () -> filled ( 'job-id' ) )
                $candidates -> where ( [ 'job_id' => request ( 'job-id' ) ] );
            
            if ( request () -> filled ( 'referral-id' ) )
                $candidates -> where ( [ 'referral_id' => request ( 'referral-id' ) ] );
            
            $perPage = 50;
            if ( request () -> has ( 'per-page' ) && request () -> has ( 'per-page' ) >= 50 && request () -> has ( 'per-page' ) <= 500 )
                $perPage = request () -> input ( 'per-page' );
            
            return $candidates -> latest () -> paginate ( $perPage );
        }
        
        public function save ( $request ) {
            $record = DataBank ::create ( [
                                              'user_id'                   => auth () -> user () -> id,
                                              'job_id'                    => $request -> input ( 'job-id' ),
                                              'qualification_id'          => $request -> input ( 'qualification-id' ),
                                              'country_id'                => $request -> input ( 'country-id' ),
                                              'city_id'                   => $request -> input ( 'city-id' ),
                                              'lead_source_id'            => $request -> input ( 'lead-source-id' ),
                                              'referral_id'               => $request -> input ( 'referral-id' ),
                                              'province_id'               => $request -> input ( 'province-id' ),
                                              'district_id'               => $request -> input ( 'district-id' ),
                                              'first_name'                => $request -> input ( 'first-name' ),
                                              'last_name'                 => $request -> input ( 'last-name' ),
                                              'father_name'               => $request -> input ( 'father-name' ),
                                              'mother_name'               => $request -> input ( 'mother-name' ),
                                              'mobile'                    => $request -> input ( 'mobile' ),
                                              'alt_no'                    => $request -> input ( 'alt-no' ),
                                              'cnic'                      => $request -> input ( 'cnic' ),
                                              'dob'                       => $request -> input ( 'dob' ),
                                              'cnic_expiry_date'          => $request -> input ( 'cnic-expiry-date' ),
                                              'religion'                  => $request -> input ( 'religion' ),
                                              'marital_status'            => $request -> input ( 'marital-status' ),
                                              'age'                       => $request -> input ( 'age' ),
                                              'gender'                    => $request -> input ( 'gender' ),
                                              'blood_group'               => $request -> input ( 'blood-group' ),
                                              'passport'                  => $request -> input ( 'passport' ),
                                              'passport_issue_date'       => $request -> input ( 'passport-issue-date' ),
                                              'passport_issue_country_id' => $request -> input ( 'issue-country-id' ),
                                              'passport_expiry_date'      => $request -> input ( 'passport-expiry-date' ),
                                              'next_of_kin'               => $request -> input ( 'next-of-kin' ),
                                              'next_of_cnic'              => $request -> input ( 'next-of-kin-cnic' ),
                                              'kin_relationship'          => $request -> input ( 'kin-relationship' ),
                                              'contact_no'                => $request -> input ( 'contact-no' ),
                                              'shirt_size'                => $request -> input ( 'shirt-size' ),
                                              'trouser_size'              => $request -> input ( 'trouser-size' ),
                                              'shoes_size'                => $request -> input ( 'shoes-size' ),
                                              'weight'                    => $request -> input ( 'weight' ),
                                              'height'                    => $request -> input ( 'height' ),
                                              'email'                     => $request -> input ( 'email' ),
                                              'address'                   => $request -> input ( 'address' ),
                                          ] );
            ( new LogService() ) -> log ( 'data-bank-added', $record );
            return $record;
        }
        
        public function update ( $request, $data_bank ) {
            $data_bank -> user_id                   = auth () -> user () -> id;
            $data_bank -> job_id                    = $request -> input ( 'job-id' );
            $data_bank -> qualification_id          = $request -> input ( 'qualification-id' );
            $data_bank -> country_id                = $request -> input ( 'country-id' );
            $data_bank -> city_id                   = $request -> input ( 'city-id' );
            $data_bank -> lead_source_id            = $request -> input ( 'lead-source-id' );
            $data_bank -> referral_id               = $request -> input ( 'referral-id' );
            $data_bank -> province_id               = $request -> input ( 'province-id' );
            $data_bank -> district_id               = $request -> input ( 'district-id' );
            $data_bank -> first_name                = $request -> input ( 'first-name' );
            $data_bank -> last_name                 = $request -> input ( 'last-name' );
            $data_bank -> father_name               = $request -> input ( 'father-name' );
            $data_bank -> mother_name               = $request -> input ( 'mother-name' );
            $data_bank -> mobile                    = $request -> input ( 'mobile' );
            $data_bank -> alt_no                    = $request -> input ( 'alt-no' );
            $data_bank -> cnic                      = $request -> input ( 'cnic' );
            $data_bank -> dob                       = $request -> input ( 'dob' );
            $data_bank -> cnic_expiry_date          = $request -> input ( 'cnic-expiry-date' );
            $data_bank -> religion                  = $request -> input ( 'religion' );
            $data_bank -> marital_status            = $request -> input ( 'marital-status' );
            $data_bank -> age                       = $request -> input ( 'age' );
            $data_bank -> gender                    = $request -> input ( 'gender' );
            $data_bank -> blood_group               = $request -> input ( 'blood-group' );
            $data_bank -> passport                  = $request -> input ( 'passport' );
            $data_bank -> passport_issue_date       = $request -> input ( 'passport-issue-date' );
            $data_bank -> passport_issue_country_id = $request -> input ( 'issue-country-id' );
            $data_bank -> passport_expiry_date      = $request -> input ( 'passport-expiry-date' );
            $data_bank -> next_of_kin               = $request -> input ( 'next-of-kin' );
            $data_bank -> next_of_cnic              = $request -> input ( 'next-of-kin-cnic' );
            $data_bank -> kin_relationship          = $request -> input ( 'kin-relationship' );
            $data_bank -> contact_no                = $request -> input ( 'contact-no' );
            $data_bank -> shirt_size                = $request -> input ( 'shirt-size' );
            $data_bank -> trouser_size              = $request -> input ( 'trouser-size' );
            $data_bank -> shoes_size                = $request -> input ( 'shoes-size' );
            $data_bank -> weight                    = $request -> input ( 'weight' );
            $data_bank -> height                    = $request -> input ( 'height' );
            $data_bank -> email                     = $request -> input ( 'email' );
            $data_bank -> address                   = $request -> input ( 'address' );
            $data_bank -> update ();
            
            ( new LogService() ) -> log ( 'data-bank-updated', $data_bank );
            return $data_bank;
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'data-bank-deleted', $model );
        }
    }