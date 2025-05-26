<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\CompanyFormRequest;
    use App\Models\Company;
    use App\Services\CompanyService;
    use App\Services\AccountService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class CompanyController extends Controller {

        public function index (): View {
            $this -> authorize ( 'all', Company::class );
            $title     = 'All Companies';
            $companies = ( new CompanyService() ) -> companies ();
            return view ( 'companies.index', compact ( 'title', 'companies' ) );
        }

        public function create (): View {
            $this -> authorize ( 'create', Company::class );
            $title = 'All Company';
            return view ( 'companies.create', compact ( 'title' ) );
        }

        public function store ( CompanyFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Company::class );
            try {
                DB ::beginTransaction ();
                $company = ( new CompanyService() ) -> add ( $request );
                $account_head = ( new AccountService() ) -> save ( $request -> merge ( [
                    "account-head-id" => "9",
                    "account-type-id" => "4",
                    "name"            => $request -> title,
                    "phone"           => $request -> contact,
                ] ) );
                DB ::commit ();

                if ( $company )
                    return redirect () -> route ( 'companies.create' ) -> with ( 'success', 'Company has been created.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Please try again.' ) -> withInput ();
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function edit ( Company $company ): View {
            $this -> authorize ( 'edit', $company );
            $title = 'Edit Company';
            return view ( 'companies.update', compact ( 'title', 'company' ) );
        }

        public function update ( CompanyFormRequest $request, Company $company ): RedirectResponse {
            $this -> authorize ( 'update', $company );
            try {
                DB ::beginTransaction ();
                ( new CompanyService() ) -> update ( $request, $company );
                DB ::commit ();

                return redirect () -> route ( 'companies.edit', [ 'company' => $company -> id ] ) -> with ( 'success', 'Company has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function destroy ( Company $company ): RedirectResponse {
            $this -> authorize ( 'delete', $company );
            try {
                DB ::beginTransaction ();
                ( new CompanyService() ) -> delete ( $company );
                DB ::commit ();

                return redirect () -> route ( 'companies.index' ) -> with ( 'success', 'Company has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
