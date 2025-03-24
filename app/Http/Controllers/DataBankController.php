<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\DataBankFormRequest;
    use App\Models\DataBank;
    use App\Services\CityService;
    use App\Services\CountryService;
    use App\Services\DataBankService;
    use App\Services\DistrictService;
    use App\Services\JobService;
    use App\Services\LeadSourceService;
    use App\Services\ProvinceService;
    use App\Services\QualificationService;
    use App\Services\ReferralService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class DataBankController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', DataBank::class );
            $data[ 'title' ]      = "All CV's";
            $data[ 'candidates' ] = ( new DataBankService() ) -> all ();
            $data[ 'jobs' ]       = ( new JobService() ) -> all ();
            $data[ 'referrals' ]  = ( new ReferralService() ) -> all ();
            return view ( 'data-banks.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', DataBank::class );
            $data[ 'title' ]          = 'Add CV';
            $data[ 'jobs' ]           = ( new JobService() ) -> all ();
            $data[ 'qualifications' ] = ( new QualificationService() ) -> all ();
            $data[ 'countries' ]      = ( new CountryService() ) -> all ();
            $data[ 'cities' ]         = ( new CityService() ) -> get_cities_by_country_id ( 1 );
            $data[ 'sources' ]        = ( new LeadSourceService() ) -> sources ();
            $data[ 'referrals' ]      = ( new ReferralService() ) -> all ();
            $data[ 'provinces' ]      = ( new ProvinceService() ) -> all ();
            $data[ 'districts' ]      = ( new DistrictService() ) -> all ();
            return view ( 'data-banks.create', $data );
        }
        
        public function store ( DataBankFormRequest $request ): RedirectResponse {
            try {
                DB ::beginTransaction ();
                $candidate = ( new DataBankService() ) -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $candidate ) )
                    return redirect () -> back () -> with ( 'success', 'CV has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( DataBank $data_bank ): View {
            $this -> authorize ( 'edit', $data_bank );
            $data[ 'title' ]          = 'Edit CV';
            $data[ 'jobs' ]           = ( new JobService() ) -> all ();
            $data[ 'qualifications' ] = ( new QualificationService() ) -> all ();
            $data[ 'countries' ]      = ( new CountryService() ) -> all ();
            $data[ 'cities' ]         = ( new CityService() ) -> get_cities_by_country_id ( $data_bank -> country_id );
            $data[ 'sources' ]        = ( new LeadSourceService() ) -> sources ();
            $data[ 'referrals' ]      = ( new ReferralService() ) -> all ();
            $data[ 'provinces' ]      = ( new ProvinceService() ) -> all ();
            $data[ 'districts' ]      = ( new DistrictService() ) -> all ();
            $data[ 'data_bank' ]      = $data_bank;
            return view ( 'data-banks.update', $data );
        }
        
        public function update ( DataBankFormRequest $request, DataBank $data_bank ): RedirectResponse {
            try {
                DB ::beginTransaction ();
                ( new DataBankService() ) -> update ( $request, $data_bank );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'CV has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( DataBank $data_bank ) {
            try {
                DB ::beginTransaction ();
                ( new DataBankService() ) -> delete ( $data_bank );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'CV has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
