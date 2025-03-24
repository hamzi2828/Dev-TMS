<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateDocumentReady;
    use App\Models\CandidateInterview;
    use App\Models\CandidatePaymentFollowUp;
    use App\Models\CandidateProtector;
    use App\Models\CandidateTicket;
    use App\Models\CandidateVisa;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\File;
    
    class CandidatePaymentFollowUpService {
        
        public function save ( $request, $candidate ) {
            $followup = CandidatePaymentFollowUp ::create ( [
                                                                'user_id'      => auth () -> user () -> id,
                                                                'candidate_id' => $candidate -> id,
                                                                'status'       => $request -> input ( 'status' ),
                                                                'description'  => $request -> input ( 'description' ),
                                                            ] );
            ( new LogService() ) -> log ( 'candidate-payment-follow-up-added', $request );
            return $followup;
        }
        
        public function edit ( $request, $model ): void {
            $model -> user_id     = auth () -> user () -> id;
            $model -> status      = $request -> input ( 'status' );
            $model -> description = $request -> input ( 'description' );
            $model -> update ();
            ( new LogService() ) -> log ( 'candidate-payment-follow-up-updated', $model );
        }
    }