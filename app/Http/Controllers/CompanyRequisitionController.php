<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CompanyRequisitionFormRequest;
    use App\Models\CompanyRequisition;
    use App\Services\CompanyRequisitionJobService;
    use App\Services\CompanyRequisitionService;
    use App\Services\CompanyService;
    use App\Services\JobService;
    use App\Services\PrincipalService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CompanyRequisitionController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', CompanyRequisition::class );
            $title        = 'All MRF';
            $requisitions = ( new CompanyRequisitionService() ) -> all ();
            return view ( 'requisitions.index', compact ( 'title', 'requisitions' ) );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', CompanyRequisition::class );
            $title      = 'All MRF';
            $companies  = ( new CompanyService() ) -> companies ();
            $jobs       = ( new JobService() ) -> all ();
            $principals = ( new PrincipalService() ) -> all ();
            return view ( 'requisitions.create', compact ( 'title', 'companies', 'jobs', 'principals' ) );
        }
        
        public function add_more (): string {
            $jobs = ( new JobService() ) -> all ();
            return view ( 'requisitions.add-more', compact ( 'jobs' ) ) -> render ();
        }
        
        public function load_company_requisitions ( Request $request ): string {
            $jobs = ( new CompanyRequisitionService() ) -> get_company_requisitions ( $request );
            return view ( 'requisitions.profession-requisitions', compact ( 'jobs' ) ) -> render ();
        }
        
        public function store ( CompanyRequisitionFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', CompanyRequisition::class );
            try {
                DB ::beginTransaction ();
                $requisition = ( new CompanyRequisitionService() ) -> add ( $request );
                ( new CompanyRequisitionJobService() ) -> add ( $request, $requisition );
                DB ::commit ();
                
                if ( $requisition )
                    return redirect () -> back () -> with ( 'success', 'MRF has been created.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Please try again.' ) -> withInput ();
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( CompanyRequisition $company_requisition ): View {
            $this -> authorize ( 'edit', $company_requisition );
            $company_requisition -> load ( [ 'jobs.job' ] );
            $title      = 'Edit MRF';
            $companies  = ( new CompanyService() ) -> companies ();
            $jobs       = ( new JobService() ) -> all ();
            $principals = ( new PrincipalService() ) -> all ();
            return view ( 'requisitions.update', compact ( 'title', 'company_requisition', 'companies', 'jobs', 'principals' ) );
        }
        
        public function update ( CompanyRequisitionFormRequest $request, CompanyRequisition $company_requisition ): RedirectResponse {
            $this -> authorize ( 'update', $company_requisition );
            try {
                DB ::beginTransaction ();
                ( new CompanyRequisitionService() ) -> update ( $request, $company_requisition );
                ( new CompanyRequisitionJobService() ) -> upsert ( $request, $company_requisition );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'MRF has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( CompanyRequisition $company_requisition ) {
            $this -> authorize ( 'delete', $company_requisition );
            try {
                DB ::beginTransaction ();
                ( new CompanyRequisitionService() ) -> delete ( $company_requisition );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'MRF has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
