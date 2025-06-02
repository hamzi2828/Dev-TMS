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
    use Illuminate\Support\Facades\Mail;
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
                    return redirect () -> intended ( route ( 'login' ) ) -> with ( 'Register', 'Please contact admin for account activation.' );
                }
                else
                    return redirect () -> back () -> with ( 'error', 'Invalid Credentials.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () );
            }
        }

        public function forgotPassword (): View {
            $title = 'Forgot Password';
            return view ( 'forgotPassword.index', compact ( 'title' ) );
        }

        public function sendResetLink(Request $request): RedirectResponse {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ], [
                'email.exists' => 'We could not find a user with that email address.'
            ]);

            try {
                // Find the user
                $user = User::where('email', $request->email)->first();

                // Generate a new random password
                $newPassword = $this->generateRandomPassword();

                // Update the user's password
                $user->password = bcrypt($newPassword);
                $user->save();

                // Create password reset email
                $passwordResetMail = new \App\Mail\PasswordReset($user, $newPassword);
                
                // Send using PHPMailer
                $emailSent = $passwordResetMail->sendWithPhpMailer($user->email);
                
                if ($emailSent) {
                    return redirect()->back()->with('status', 'We have emailed your new password!');
                } else {
                    // If email fails, still show the password to the user
                    return redirect()->back()->with([
                        'status' => 'Your password has been reset, but we could not send the email. Your new password is: ' . $newPassword,
                        'error' => 'Email could not be sent. Please make note of your new password.'
                    ]);
                }
            } catch (\Exception $exception) {
                Log::error($exception);
                return redirect()->back()->with('error', 'There was a problem sending the password reset email. Please try again later.');
            }
        }

        private function generateRandomPassword($length = 10): string {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_-=+';
            $password = '';
            $max = strlen($characters) - 1;

            for ($i = 0; $i < $length; $i++) {
                $password .= $characters[random_int(0, $max)];
            }

            return $password;
        }

    }
