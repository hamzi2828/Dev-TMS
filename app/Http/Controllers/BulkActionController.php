<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Account;
    use App\Models\Candidate;
    use App\Services\LogService;
    use Illuminate\Http\Request;
    
    class BulkActionController extends Controller {
        
        public function update_candidate_account_head () {
            $candidates = Candidate ::whereNotNull ( 'account_head_id' ) -> get ();
            
            if ( count ( $candidates ) > 0 ) {
                foreach ( $candidates as $candidate ) {
                    $accountHead = Account ::find ( $candidate -> account_head_id );
                    
                    if ( $accountHead ) {
                        $accountHead -> name = $candidate -> fullName () . ' (' . $candidate -> srNo () . ')';
                        $accountHead -> update ();
                    }
                }
            }
        }
        
    }
