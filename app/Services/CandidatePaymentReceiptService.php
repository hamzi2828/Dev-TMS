<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateInterview;
    use App\Models\CandidatePaymentFollowUp;
    use App\Models\CandidatePaymentReceipt;
    use App\Models\CandidateTicketFollowUp;
    use App\Models\CandidateVisaFollowUp;
    use App\Models\Fee;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\File;
    
    class CandidatePaymentReceiptService {
        
        public function save ( $request, $candidate ): void {
            $slip = CandidatePaymentReceipt ::where ( [ 'candidate_id' => $candidate -> id ] ) -> first ();
            if ( !empty( $slip ) ) {
                
                if ( $request -> has ( 'payment-slip-1' ) )
                    $slip -> receipt_1 = $this -> upload_file ( 'payment-slip-1', $candidate -> id . '/payment-slips' );
                
                if ( $request -> has ( 'payment-slip-2' ) )
                    $slip -> receipt_2 = $this -> upload_file ( 'payment-slip-2', $candidate -> id . '/payment-slips' );
                
                if ( $request -> has ( 'payment-slip-3' ) )
                    $slip -> receipt_3 = $this -> upload_file ( 'payment-slip-3', $candidate -> id . '/payment-slips' );
                
                if ( $request -> has ( 'payment-slip-4' ) )
                    $slip -> receipt_4 = $this -> upload_file ( 'payment-slip-4', $candidate -> id . '/payment-slips' );
                
                $slip -> update ();
                ( new LogService() ) -> log ( 'candidate-payment-slip-updated', $slip );
            }
            else {
                $slips = CandidatePaymentReceipt ::create ( [
                                                                'user_id'      => auth () -> user () -> id,
                                                                'candidate_id' => $candidate -> id,
                                                                'receipt_1'    => $request -> has ( 'payment-slip-1' ) ? $this -> upload_file ( 'payment-slip-1', $candidate -> id . '/payment-slips' ) : null,
                                                                'receipt_2'    => $request -> has ( 'payment-slip-2' ) ? $this -> upload_file ( 'payment-slip-2', $candidate -> id . '/payment-slips' ) : null,
                                                                'receipt_3'    => $request -> has ( 'payment-slip-3' ) ? $this -> upload_file ( 'payment-slip-3', $candidate -> id . '/payment-slips' ) : null,
                                                                'receipt_4'    => $request -> has ( 'payment-slip-4' ) ? $this -> upload_file ( 'payment-slip-4', $candidate -> id . '/payment-slips' ) : null,
                                                            ] );
                ( new LogService() ) -> log ( 'candidate-payment-slips-added', $slips );
            }
        }
        
        public function upload_file ( $file_name, $folder ): string {
            if ( !empty( trim ( $file_name ) ) ) {
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
        }
        
    }