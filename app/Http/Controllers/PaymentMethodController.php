<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\PaymentMethodFormRequest;
    use App\Models\PaymentMethod;
    use App\Services\AccountService;
    use App\Services\PaymentMethodService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class PaymentMethodController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', PaymentMethod::class );
            $data[ 'title' ]   = 'All Payment Methods';
            $data[ 'methods' ] = ( new PaymentMethodService() ) -> all ();
            return view ( 'payment-methods.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', PaymentMethod::class );
            $data[ 'title' ] = 'Add Payment Methods';
            return view ( 'payment-methods.create', $data );
        }
        
        public function store ( PaymentMethodFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', PaymentMethod::class );
            try {
                DB ::beginTransaction ();
                $method                    = ( new PaymentMethodService() ) -> save ( $request );
                $paymentMethod             = ( new AccountService() ) -> add_payment_method ( $method );
                $method -> account_head_id = $paymentMethod -> id;
                $method -> update ();
                DB ::commit ();
                
                if ( !empty( $method ) and $method -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Payment method has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( PaymentMethod $payment_method ): View {
            $this -> authorize ( 'edit', $payment_method );
            $data[ 'title' ]          = 'Edit Payment Methods';
            $data[ 'payment_method' ] = $payment_method;
            return view ( 'payment-methods.update', $data );
        }
        
        public function update ( PaymentMethodFormRequest $request, PaymentMethod $payment_method ): RedirectResponse {
            $this -> authorize ( 'edit', $payment_method );
            try {
                DB ::beginTransaction ();
                ( new PaymentMethodService() ) -> edit ( $request, $payment_method );
                ( new AccountService() ) -> edit_payment_method ( $payment_method );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Payment method has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( PaymentMethod $payment_method ): RedirectResponse {
            $this -> authorize ( 'delete', $payment_method );
            try {
                DB ::beginTransaction ();
                ( new PaymentMethodService() ) -> delete ( $payment_method );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Payment method has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
