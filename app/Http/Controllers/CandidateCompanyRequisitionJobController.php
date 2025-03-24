<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CandidateCompanyRequisitionJobFormRequest;
    use App\Models\Candidate;
    use App\Models\CandidateCompanyRequisitionJob;
    use App\Services\CandidateCompanyRequisitionJobService;
    use App\Services\CompanyRequisitionService;
    use App\Services\CompanyService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CandidateCompanyRequisitionJobController extends Controller {
        
        public function index () {
            //
        }
        
        public function create ( Candidate $candidate ): View {
            $this -> authorize ( 'create', CandidateCompanyRequisitionJob::class );
            $candidate -> load ( [ 'requisition.company_requisition_job' ] );
            $data[ 'title' ]                      = 'Add MRF';
            $data[ 'candidate' ]                  = $candidate;
            $data[ 'companies' ]                  = ( new CompanyService() ) -> companies ();
            $data[ 'jobs' ]                       = [];
            $data[ 'company_id' ]                 = null;
            $data[ 'company_requisition_job_id' ] = null;
            return view ( 'candidates.update', $data );
        }
        
        public function store ( Candidate $candidate, CandidateCompanyRequisitionJobFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', CandidateCompanyRequisitionJob::class );
            try {
                DB ::beginTransaction ();
                $requisition = ( new CandidateCompanyRequisitionJobService() ) -> save ( $request, $candidate );
                DB ::commit ();
                
                if ( !empty( $requisition ) )
                    return redirect () -> route ( 'candidates.requisitions.edit', [ 'candidate' => $candidate -> id, 'requisition' => $requisition -> id ] ) -> with ( 'success', 'Candidate MRF has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Candidate $candidate, CandidateCompanyRequisitionJob $requisition ): View {
            $this -> authorize ( 'edit', $requisition );
            $candidate -> load ( [ 'requisition.company_requisition_job.company_requisition' ] );
            $data[ 'title' ]      = 'Edit MRF';
            $data[ 'candidate' ]  = $candidate;
            $data[ 'companies' ]  = ( new CompanyService() ) -> companies ();
            $data[ 'company_id' ] = $candidate ?-> requisition ?-> company_requisition_job ?-> company_requisition ?-> company_id;
            $data[ 'company_requisition_job_id' ] = $candidate ?-> requisition ?-> company_requisition_job ?-> id;
            $data[ 'jobs' ] = ( new CompanyRequisitionService() ) -> get_company_requisitions_by_company_id ( $candidate );
            return view ( 'candidates.update', $data );
        }
        
        public function update ( CandidateCompanyRequisitionJobFormRequest $request, Candidate $candidate, CandidateCompanyRequisitionJob $requisition ) {
            $this -> authorize ( 'update', $requisition );
            try {
                DB ::beginTransaction ();
                ( new CandidateCompanyRequisitionJobService() ) -> edit ( $request, $requisition );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate MRF has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Candidate $candidate, CandidateCompanyRequisitionJob $requisition ): RedirectResponse {
            $this -> authorize ( 'delete', $requisition );
            try {
                DB ::beginTransaction ();
                ( new CandidateCompanyRequisitionJobService() ) -> delete ( $requisition );
                DB ::commit ();
                
                return redirect () -> route ( 'candidates.edit', [ 'candidate' => $candidate -> id ] ) -> with ( 'success', 'Candidate MRF has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
