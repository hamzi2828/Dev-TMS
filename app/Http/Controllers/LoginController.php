<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\LoginFormRequest;
    use App\Http\Requests\LoginRequest;
    use App\Http\Requests\RegisterFormRequest;
    use App\Services\LoginService;
    use App\Services\UserRoleService;
    use App\Models\UserRole;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;
    use App\Models\User;

    class LoginController extends Controller {

        public function index (): View {
            $title = 'Login';
            return view ( 'login.index', compact ( 'title' ) );
        }

        public function authenticate ( LoginFormRequest $request ): RedirectResponse {
            try {
                $user_id = ( new LoginService() ) -> login ( $request );
                if ( $user_id > 0 )
                    return redirect () -> intended ( route ( 'home' ) );
                else
                    return redirect () -> back () -> with ( 'error', 'Invalid Credentials.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () );
            }
        }

        public function logout ( Request $request ): RedirectResponse {
            Auth ::logout ();
            $request -> session () -> regenerate ();
            return redirect ( route ( 'login' ) );
        }

        public function register (): View {
            $title = 'Register';
            return view ( 'register.index', compact ( 'title' ) );
        }

        public function registerUser ( RegisterFormRequest $request ): RedirectResponse {
            try {
                $user_id = ( new LoginService() ) -> register ( $request );
                if ( $user_id > 0 ) {
                    // Assign role ID 23 to the registered user
                    $userRole = UserRole ::create ( [
                        'user_id' => $user_id,
                        'role_id' => 23,
                    ] );
                    return redirect () -> intended ( route ( 'login' ) ) -> with ( 'Register', 'Please contact admin.' );
                }
                else
                    return redirect () -> back () -> with ( 'error', 'Invalid Credentials.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () );
            }
        }

    }
