<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateBackOut;
    use App\Models\Fee;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Facades\DB;
    
    class CandidateBackoutService {
        
        public function save ( $request, $candidate ) {
            $backout = CandidateBackOut ::create ( [
                                                       'user_id'      => auth () -> user () -> id,
                                                       'candidate_id' => $candidate -> id,
                                                       'reason'       => $request -> input ( 'reason' ),
                                                   ] );
            ( new LogService() ) -> log ( 'candidate-backout-created', $backout );
            return $backout;
        }
        
        public function edit ( $request, $model ): void {
            $model -> user_id = auth () -> user () -> id;
            $model -> reason  = $request -> input ( 'reason' );
            $model -> update ();
            ( new LogService() ) -> log ( 'candidate-backout-updated', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'candidate-backout-deleted', $model );
        }
    }