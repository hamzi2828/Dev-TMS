<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateInterview;
    use App\Models\CandidateMedical;
    use Illuminate\Database\Eloquent\Collection;
    
    class CandidateInterviewService {
        
        public function save ( $request, $candidate ) {
            $candidate -> current_status = 'interview';
            $candidate -> update ();
            
            $interview = CandidateInterview ::create ( [
                                                           'user_id'             => auth () -> user () -> id,
                                                           'candidate_id'        => $candidate -> id,
                                                           'diagnostic'          => $request -> input ( 'diagnostic' ),
                                                           'writing'             => $request -> input ( 'writing' ),
                                                           'english'             => $request -> input ( 'spoken-english-score' ),
                                                           'ept'                 => $request -> input ( 'overall-ept' ),
                                                           'attitude'            => $request -> input ( 'attitude' ),
                                                           'experience'          => $request -> input ( 'job-experience' ),
                                                           'remarks'             => $request -> input ( 'remarks' ),
                                                           'status'              => $request -> input ( 'status' ),
                                                           'status_update_count' => '1',
                                                       ] );
            ( new LogService() ) -> log ( 'candidate-interview-created', $interview );
            return $interview;
        }
        
        public function edit ( $request, $model ): void {
            $model -> user_id             = auth () -> user () -> id;
            $model -> diagnostic          = $request -> input ( 'diagnostic' );
            $model -> writing             = $request -> input ( 'writing' );
            $model -> english             = $request -> input ( 'spoken-english-score' );
            $model -> ept                 = $request -> input ( 'overall-ept' );
            $model -> attitude            = $request -> input ( 'attitude' );
            $model -> experience          = $request -> input ( 'job-experience' );
            $model -> remarks             = $request -> input ( 'remarks' );
            $model -> status_update_count = '1';
            
            if ( $request -> filled ( 'status' ) )
                $model -> status = $request -> input ( 'status' );
            
            $model -> update ();
            ( new LogService() ) -> log ( 'candidate-interview-updated', $model );
        }
        
        public function bulk_status_update ( $request ): void {
            $candidates = $request -> input ( 'candidates' );
            $status     = $request -> input ( 'status' );
            $candidates = explode ( ',', $candidates );
            
            if ( count ( $candidates ) > 0 ) {
                foreach ( $candidates as $candidate_id ) {
                    if ( is_numeric ( $candidate_id ) && $candidate_id > 0 ) {
                        $interview = CandidateInterview ::where ( [ 'candidate_id' => $candidate_id ] )
                            -> update ( [ 'status' => $status, 'status_update_count' => '1' ] );
                        ( new LogService() ) -> log ( 'candidate-interview-status-updated', $interview );
                    }
                }
            }
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'candidate-interview-deleted', $model );
        }
        
        public function save_medical ( $candidate ) {
//            $candidate -> current_status = 'medical';
//            $candidate -> update ();
//
//            return CandidateMedical ::create ( [
//                                                   'user_id'      => auth () -> user () -> id,
//                                                   'candidate_id' => $candidate -> id,
//                                                   'status'       => null,
//                                               ] );
        }
    }