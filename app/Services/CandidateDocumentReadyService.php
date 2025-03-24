<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateDocumentReady;
    use App\Models\CandidateInterview;
    use App\Models\CandidateProtector;
    use App\Models\CandidateTicket;
    use App\Models\CandidateVisa;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\File;
    
    class CandidateDocumentReadyService {
        
        public function save ( $request, $candidate ) {
//            $candidate -> current_status = 'document-ready';
//            $candidate -> update ();
            $service = CandidateDocumentReady ::create ( [
                                                             'user_id'      => auth () -> user () -> id,
                                                             'candidate_id' => $candidate -> id,
                                                             'agreement_id' => $request -> input ( 'agreement-id' ),
                                                             'status'       => $request -> input ( 'status' ),
                                                             'reason'       => $request -> input ( 'reason' ),
                                                         ] );
            ( new LogService() ) -> log ( 'candidate-document-ready-created', $service );
            return $service;
        }
        
        public function edit ( $request, $candidate, $document_ready ): void {
            $document_ready -> agreement_id = $request -> input ( 'agreement-id' );
            
            if ( $request -> filled ( 'status' ) )
                $document_ready -> status = $request -> input ( 'status' );
            
            $document_ready -> user_id = auth () -> user () -> id;
            $document_ready -> reason  = $request -> input ( 'reason' );
            $document_ready -> update ();
            ( new LogService() ) -> log ( 'candidate-document-ready-updated', $document_ready );
        }
        
        public function bulk_status_update ( $request ): void {
            $candidates = $request -> input ( 'candidates' );
            $status     = $request -> input ( 'status' );
            $candidates = explode ( ',', $candidates );
            
            if ( count ( $candidates ) > 0 ) {
                foreach ( $candidates as $candidate_id ) {
                    if ( is_numeric ( $candidate_id ) && $candidate_id > 0 ) {
                        $ready = CandidateDocumentReady ::updateOrCreate ( [
                                                                               'candidate_id' => $candidate_id
                                                                           ],
                                                                           [
                                                                               'user_id'      => auth () -> user () -> id,
                                                                               'candidate_id' => $candidate_id,
                                                                               'status'       => $status,
                                                                           ] );
                        
                        ( new LogService() ) -> log ( 'candidate-document-ready-created-updated', $ready );

//                        $candidate                   = Candidate ::find ( $candidate_id );
//                        $candidate -> current_status = 'document-ready';
//                        $candidate -> update ();
//
//                        ( new CandidateDocumentReadyService() ) -> save_visa ( $candidate );
                    }
                }
            }
        }
        
        public function save_visa ( $candidate ) {
            $candidate -> current_status = 'visa';
            $candidate -> update ();
            
            return CandidateVisa ::create ( [
                                                'user_id'      => auth () -> user () -> id,
                                                'candidate_id' => $candidate -> id,
                                                'status'       => 'in-process',
                                            ] );
        }
    }