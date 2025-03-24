<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\LeadSourceFormRequest;
    use App\Models\LeadSource;
    use App\Services\LeadSourceService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class LeadSourceController extends Controller {
        
        public function index (): View {
            $data[ 'title' ]   = 'All Lead Sources';
            $data[ 'sources' ] = ( new LeadSourceService() ) -> sources ();
            return view ( 'lead-sources.index', $data );
        }
        
        public function create (): View {
            $data[ 'title' ] = 'Add Lead Source';
            return view ( 'lead-sources.create', $data );
        }
        
        public function store ( LeadSourceFormRequest $request ) {
            try {
                DB ::beginTransaction ();
                $purpose = ( new LeadSourceService() ) -> save ( $request );
                DB ::commit ();
                
                if ( $purpose )
                    return redirect () -> back () -> with ( 'success', 'Lead source has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( LeadSource $lead_source ): View {
            $data[ 'title' ]  = 'Edit Lead Source';
            $data[ 'source' ] = $lead_source;
            return view ( 'lead-sources.update', $data );
        }
        
        public function update ( LeadSourceFormRequest $request, LeadSource $lead_source ) {
            try {
                DB ::beginTransaction ();
                ( new LeadSourceService() ) -> update ( $request, $lead_source );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Lead source has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( LeadSource $lead_source ) {
            try {
                DB ::beginTransaction ();
                ( new LeadSourceService() ) -> delete ( $lead_source );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Lead source has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
