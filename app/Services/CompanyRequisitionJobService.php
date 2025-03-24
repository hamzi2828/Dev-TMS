<?php
    
    namespace App\Services;
    
    use App\Models\Company;
    use App\Models\CompanyRequisition;
    use App\Models\CompanyRequisitionJob;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Str;
    
    class CompanyRequisitionJobService {
        
        public function all (): Collection {
            return CompanyRequisitionJob ::all ();
        }
        
        public function add ( $request, $requisition ): void {
            $jobs  = $request -> input ( 'jobs', [] );
            $quota = $request -> input ( 'quota', [] );
            
            if ( count ( $jobs ) > 0 ) {
                foreach ( $jobs as $key => $job_id ) {
                    $job = CompanyRequisitionJob ::create ( [
                                                                'company_requisition_id' => $requisition -> id,
                                                                'job_id'                 => $job_id,
                                                                'quota'                  => $quota[ $key ],
                                                            ] );
                    ( new LogService() ) -> log ( 'requisition-job-added', $job );
                }
            }
        }
        
        public function upsert ( $request, $requisition ): void {
            $requisition_jobs  = $request -> input ( 'requisition-jobs', [] );
            $requisition_quota = $request -> input ( 'requisition-quota', [] );
            
            if ( count ( $requisition_jobs ) > 0 ) {
                foreach ( $requisition_jobs as $key => $requisition_job_id ) {
                    $job          = CompanyRequisitionJob ::find ( $requisition_job_id );
                    $job -> quota = $requisition_quota[ $key ];
                    $job -> update ();
                    ( new LogService() ) -> log ( 'requisition-job-updated', $job );
                }
            }
            
            $this -> add ( $request, $requisition );
        }
        
        public function delete ( $company ): void {
            $company -> delete ();
            ( new LogService() ) -> log ( 'requisition-job-deleted', $company );
        }
    }