<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\AgentFormRequest;
    use App\Models\Agent;
    use App\Services\AgentService;
    use App\Services\AccountService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class AgentController extends Controller {

        public function index (): View {
            $this -> authorize ( 'all', Agent::class );
            $data[ 'title' ]  = 'All Travel Agents';
            $data[ 'agents' ] = ( new AgentService() ) -> all ();
            return view ( 'agents.index', $data );
        }

        public function create (): View {
            $this -> authorize ( 'create', Agent::class );
            $data[ 'title' ] = 'Add Travel Agent';
            return view ( 'agents.create', $data );
        }

        public function store ( AgentFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Agent::class );
            try {

                DB ::beginTransaction ();
                $agent = ( new AgentService() ) -> save ( $request );

                $account_head = ( new AccountService() ) -> save ( $request -> merge ( [
                    "account-head-id" => "17",
                    "account-type-id" => "5",
                    "name"            => $request -> title,
                    "phone"           => $request -> contact,
                ] ) );
                DB ::commit ();


                if ( !empty( $agent ) and $agent -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Agent has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function edit ( Agent $agent ): View {
            $this -> authorize ( 'edit', $agent );
            $data[ 'title' ] = 'Edit Travel Agent';
            $data[ 'agent' ] = $agent;
            return view ( 'agents.update', $data );
        }

        public function update ( AgentFormRequest $request, Agent $agent ): RedirectResponse {
            $this -> authorize ( 'update', $agent );
            try {
                DB ::beginTransaction ();
                ( new AgentService() ) -> edit ( $request, $agent );
                DB ::commit ();

                return redirect () -> back () -> with ( 'success', 'Agent has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function destroy ( Agent $agent ): RedirectResponse {
            $this -> authorize ( 'delete', $agent );
            try {
                DB ::beginTransaction ();
                ( new AgentService() ) -> delete ( $agent );
                DB ::commit ();

                return redirect () -> back () -> with ( 'success', 'Agent has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
