<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateCompanyRequisitionJob;
    use App\Models\CandidateInterview;
    use App\Models\CandidateMedical;
    use App\Models\Fee;
    use App\Models\Vendor;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\File;
    
    class CandidateCompanyRequisitionJobService {
        
        public function save ( $request, $candidate ) {
            $requisition = CandidateCompanyRequisitionJob ::create ( [
                                                                         'user_id'                    => auth () -> user () -> id,
                                                                         'candidate_id'               => $candidate -> id,
                                                                         'company_requisition_job_id' => $request -> input ( 'company-requisition-job-id' ),
                                                                     ] );
            ( new LogService() ) -> log ( 'candidate-requisition-job-created', $requisition );
            return $requisition;
        }
        
        public function count_allocated_quota ( $job_id ) {
            return CandidateCompanyRequisitionJob ::where ( [ 'company_requisition_job_id' => $job_id ] ) -> count ();
        }
        
        public function edit ( $request, $model ): void {
            $model -> user_id                    = auth () -> user () -> id;
            $model -> company_requisition_job_id = $request -> input ( 'company-requisition-job-id' );
            $model -> update ();
            ( new LogService() ) -> log ( 'candidate-requisition-job-updated', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'candidate-requisition-job-deleted', $model );
        }
    }