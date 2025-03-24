<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateInterview;
    use App\Models\CandidateMedical;
    use App\Models\Fee;
    use App\Models\Vendor;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\File;
    
    class CandidateMedicalService {
        
        public function save ( $request, $candidate ) {
            $candidate -> current_status = 'medical';
            $candidate -> blood_group    = $request -> input ( 'blood-group' );
            $candidate -> update ();
            
            $vendor  = Vendor ::find ( $request -> input ( 'vendor-id' ) );
            $medical = CandidateMedical ::create ( [
                                                       'user_id'           => auth () -> user () -> id,
                                                       'candidate_id'      => $candidate -> id,
                                                       'payment_method_id' => $request -> input ( 'payment-method' ),
                                                       'vendor_id'         => $vendor ?-> id,
                                                       'amount'            => $vendor ?-> fee,
                                                       'payable'           => $vendor ?-> vendor_payable,
                                                       'transaction_no'    => $request -> input ( 'transaction-no' ),
                                                       'status'            => $request -> input ( 'status', null ),
                                                       'file'              => $request -> has ( 'file' ) ? $this -> upload_file ( 'file', $candidate -> id . '/medical' ) : null,
                                                   ] );
            ( new LogService() ) -> log ( 'candidate-medical-added', $medical );
            return $medical;
        }
        
        public function edit ( $request, $model ): void {
            if ( $request -> filled ( 'transaction-no' ) )
                $model -> transaction_no = $request -> input ( 'transaction-no' );
            
            if ( $request -> filled ( 'status' ) )
                $model -> status = $request -> input ( 'status' );
            
            if ( $request -> has ( 'file' ) )
                $model -> file = $this -> upload_file ( 'file', $model -> id . '/medical' );
            
            $model -> user_id = auth () -> user () -> id;
            $model -> update ();
            
            $candidate  = Candidate ::find ( $model -> candidate_id );
            $candidate -> blood_group    = $request -> input ( 'blood-group' );
            $candidate -> update ();
            
            ( new LogService() ) -> log ( 'candidate-medical-updated', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'candidate-medical-deleted', $model );
        }
        
        public function upload_file ( $file_name, $folder ): string {
            $path = 'uploads/candidates/' . $folder . '/';
            $dir  = public_path ( $path );
            $file = request () -> file ( $file_name );
            
            if ( !File ::isDirectory ( $dir ) ) {
                File ::makeDirectory ( $dir, 0755, true, true );
            }
            
            $fileName = time () . '-' . $file -> getClientOriginalName ();
            $file -> move ( $dir, $fileName );
            return ( asset ( $path . $fileName ) );
        }
        
        public function bulk_status_update ( $request ): void {
            $candidates = $request -> input ( 'candidates' );
            $status     = $request -> input ( 'status' );
            $candidates = explode ( ',', $candidates );
            
            if ( count ( $candidates ) > 0 ) {
                foreach ( $candidates as $candidate_id ) {
                    if ( is_numeric ( $candidate_id ) && $candidate_id > 0 ) {
                        $medical = CandidateMedical ::where ( [ 'candidate_id' => $candidate_id ] )
                            -> update ( [ 'status' => $status ] );
                        
                        ( new LogService() ) -> log ( 'candidate-medical-bulk-status-updated', $medical );
                        
                        $candidate = Candidate ::find ( $candidate_id );
                        
                        if ( $status == 'fit' && empty( trim ( $candidate -> account_head_id ) ) ) {
                            $account_head = ( new AccountService() ) -> add_candidate ( $request, $candidate );
                            ( new CandidateService() ) -> add_candidate_account_head_id ( $candidate, $account_head -> id );
                            ( new GeneralLedgerService() ) -> candidate_agreed_amount ( $candidate );
                        }
                        
                    }
                }
            }
        }
    }