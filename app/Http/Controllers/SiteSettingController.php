<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\SiteSetting;
    use App\Services\SiteSettingService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class SiteSettingController extends Controller {
        
        public function index () {
            //
        }
        
        public function create (): View {
            $this -> authorize ( 'create', SiteSetting::class );
            $data[ 'title' ]    = 'Site Settings';
            $data[ 'settings' ] = ( new SiteSettingService() ) -> settings ();
            return view ( 'site-settings.create', $data );
        }
        
        public function store ( Request $request ): RedirectResponse {
            $this -> authorize ( 'create', SiteSetting::class );
            try {
                DB ::beginTransaction ();
                ( new SiteSettingService() ) -> save ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Settings have been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( string $id ) {
            //
        }
        
        public function update ( Request $request, string $id ) {
            //
        }
        
        public function destroy ( string $id ) {
            //
        }
    }
