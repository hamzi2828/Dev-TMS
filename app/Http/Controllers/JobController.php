<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\JobFormRequest;
    use App\Models\Job;
    use App\Services\JobService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class JobController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Job::class );
            $data[ 'title' ] = 'All Professions';
            $data[ 'jobs' ]  = ( new JobService() ) -> all ();
            return view ( 'jobs.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Job::class );
            $data[ 'title' ] = 'Add Profession';
            return view ( 'jobs.create', $data );
        }
        
        public function store ( JobFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Job::class );
            try {
                DB ::beginTransaction ();
                $job = ( new JobService() ) -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $job ) and $job -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Job has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Job $job ): View {
            $this -> authorize ( 'edit', $job );
            $data[ 'title' ] = 'Edit Profession';
            $data[ 'job' ]   = $job;
            return view ( 'jobs.update', $data );
        }
        
        public function update ( JobFormRequest $request, Job $job ): RedirectResponse {
            $this -> authorize ( 'update', $job );
            try {
                DB ::beginTransaction ();
                ( new JobService() ) -> edit ( $request, $job );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Job has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Job $job ) {
            $this -> authorize ( 'delete', $job );
            try {
                DB ::beginTransaction ();
                ( new JobService() ) -> delete ( $job );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Job has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
