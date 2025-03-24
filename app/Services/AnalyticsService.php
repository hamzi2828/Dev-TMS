<?php
    
    namespace App\Services;
    
    use App\Http\Helpers\GeneralHelper;
    use App\Models\Account;
    use App\Models\GeneralLedger;
    use App\Models\MonthModel;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\Cache;
    
    class AnalyticsService {
        
        public function payable () {
            $account_head_id = config ( 'constants.account_payable' );
            $running_balance = 0;
            
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id' );
            $account -> selectRaw ( 'SUM(credit) as credit' );
            $account -> selectRaw ( 'SUM(debit) as debit' );
            
            $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'account_head_id' => $account_head_id ] );
            } );

//            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
//                $account -> where ( [ 'user_id' => auth () -> user () -> id ] );
//            }
            
            $records      = $account -> groupBy ( 'account_head_id' ) -> get ();
            $account_head = Account ::where ( [ 'id' => $account_head_id ] ) -> with ( 'account_type' ) -> first ();
            
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    $running_balance = ( new GeneralLedgerService() ) -> calculate_running_balance ( $running_balance, $record -> credit, $record -> debit, $account_head );
                }
            }
            
            return ( ( new GeneralHelper() ) -> format_currency ( abs ( $running_balance ) ) );
        }
        
        public function receivable () {
            $account_head_id = config ( 'constants.account_receivable' );
            $running_balance = 0;
            
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id' );
            $account -> selectRaw ( 'SUM(credit) as credit' );
            $account -> selectRaw ( 'SUM(debit) as debit' );
            
            $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'account_head_id' => $account_head_id ] );
            } );

//            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
//                $account -> where ( [ 'user_id' => auth () -> user () -> id ] );
//            }
            
            $records      = $account -> groupBy ( 'account_head_id' ) -> get ();
            $account_head = Account ::where ( [ 'id' => $account_head_id ] ) -> with ( 'account_type' ) -> first ();
            
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    $running_balance = ( new GeneralLedgerService() ) -> calculate_running_balance ( $running_balance, $record -> credit, $record -> debit, $account_head );
                }
            }
            
            return ( ( new GeneralHelper() ) -> format_currency ( abs ( $running_balance ) ) );
        }
        
        public function banks_balances (): array {
            $ids           = [ config ( 'constants.banks' ) ];
            $account_heads = Account ::whereIn ( 'account_head_id', $ids ) -> get ();
            $array         = [];
            
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $account_head ) {
                    $running_balance    = ( new AccountService() ) -> get_account_head_running_balance ( $account_head -> id, null, true );
                    $array[ 'title' ][] = $account_head -> name;
                    $array[ 'value' ][] = abs ( $running_balance );
                }
            }
            
            return $array;
        }
        
        public function daily_cash_balances (): array {
            $ids           = [
                config ( 'constants.cash_balances' ),
                config ( 'constants.banks' ),
            ];
            $account_heads = Account ::whereIn ( 'account_head_id', $ids ) -> get ();
            $array         = [];
            $sum           = 0;
            
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $account_head ) {
                    $running_balance    = ( new AccountService() ) -> get_daily_account_head_running_balance ( $account_head -> id );
                    $array[ 'title' ][] = $account_head -> name;
                    $array[ 'value' ][] = abs ( $running_balance );
                    $sum                += abs ( $running_balance );
                }
                $array[ 'sum' ] = $sum;
            }
            
            return $array;
        }
        
        public function income_from_test () {
            $account_head_id = config ( 'constants.income_from_test' );
            $running_balance = 0;
            
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id' );
            $account -> selectRaw ( 'SUM(credit) as credit' );
            $account -> selectRaw ( 'SUM(debit) as debit' );
            $account -> where ( [ 'account_head_id' => $account_head_id ] );
            
            $records      = $account -> groupBy ( 'account_head_id' ) -> get ();
            $account_head = Account ::where ( [ 'id' => $account_head_id ] ) -> with ( 'account_type' ) -> first ();
            
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    $running_balance = ( new GeneralLedgerService() ) -> calculate_running_balance ( $running_balance, $record -> credit, $record -> debit, $account_head );
                }
            }
            
            return ( ( new GeneralHelper() ) -> format_currency ( abs ( $running_balance ) ) );
        }
        
        public function income_from_medical () {
            $account_head_id = config ( 'constants.income_from_medical' );
            $running_balance = 0;
            
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id' );
            $account -> selectRaw ( 'SUM(credit) as credit' );
            $account -> selectRaw ( 'SUM(debit) as debit' );
            $account -> where ( [ 'account_head_id' => $account_head_id ] );
            
            $records      = $account -> groupBy ( 'account_head_id' ) -> get ();
            $account_head = Account ::where ( [ 'id' => $account_head_id ] ) -> with ( 'account_type' ) -> first ();
            
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    $running_balance = ( new GeneralLedgerService() ) -> calculate_running_balance ( $running_balance, $record -> credit, $record -> debit, $account_head );
                }
            }
            
            return ( ( new GeneralHelper() ) -> format_currency ( abs ( $running_balance ) ) );
        }
        
        public function income_from_candidate () {
            $account_head_id = config ( 'constants.income_from_candidate' );
            $running_balance = 0;
            
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id' );
            $account -> selectRaw ( 'SUM(credit) as credit' );
            $account -> selectRaw ( 'SUM(debit) as debit' );
            $account -> where ( [ 'account_head_id' => $account_head_id ] );
            
            $records      = $account -> groupBy ( 'account_head_id' ) -> get ();
            $account_head = Account ::where ( [ 'id' => $account_head_id ] ) -> with ( 'account_type' ) -> first ();
            
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    $running_balance = ( new GeneralLedgerService() ) -> calculate_running_balance ( $running_balance, $record -> credit, $record -> debit, $account_head );
                }
            }
            
            return ( ( new GeneralHelper() ) -> format_currency ( abs ( $running_balance ) ) );
        }
        
        public function month_names () {
            return Cache ::remember ( 'months', 120, function () {
                return MonthModel ::pluck ( 'short_name' ) -> toArray ();
            } );
        }
        
        public function months (): Collection {
            return MonthModel ::all ();
        }
        
        public function banks_balances_month_wise ( $account_head_id, $month ): array {
            $account_heads = Account ::where ( [ 'id' => $account_head_id ] ) -> get ();
            $array         = [];
            
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $account_head ) {
                    $running_balance    = ( new AccountService() ) -> get_account_head_running_balance ( $account_head -> id, null, false, $month );
                    $array[ 'title' ][] = $account_head -> name;
                    $array[ 'value' ][] = abs ( $running_balance );
                }
            }
            
            return $array;
        }
    }