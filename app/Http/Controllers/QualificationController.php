<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\QualificationFormRequest;
    use App\Models\Qualification;
    use App\Services\QualificationService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class QualificationController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Qualification::class );
            $data[ 'title' ]          = 'All Qualifications';
            $data[ 'qualifications' ] = ( new QualificationService() ) -> all ();
            return view ( 'qualifications.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Qualification::class );
            $data[ 'title' ] = 'All Qualification';
            return view ( 'qualifications.create', $data );
        }
        
        public function store ( QualificationFormRequest $request ) {
            $this -> authorize ( 'create', Qualification::class );
            try {
                DB ::beginTransaction ();
                $model = ( new QualificationService() ) -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $model ) and $model -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Qualification has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Qualification $qualification ): View {
            $this -> authorize ( 'edit', $qualification );
            $data[ 'title' ]         = 'All Qualification';
            $data[ 'qualification' ] = $qualification;
            return view ( 'qualifications.update', $data );
        }
        
        public function update ( QualificationFormRequest $request, Qualification $qualification ) {
            $this -> authorize ( 'edit', $qualification );
            try {
                DB ::beginTransaction ();
                ( new QualificationService() ) -> edit ( $request, $qualification );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Qualification has been update.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Qualification $qualification ) {
            $this -> authorize ( 'delete', $qualification );
            try {
                DB ::beginTransaction ();
                ( new QualificationService() ) -> delete ( $qualification );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Qualification has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
