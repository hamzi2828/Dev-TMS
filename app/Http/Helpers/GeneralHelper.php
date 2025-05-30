<?php
    
    namespace App\Http\Helpers;
    
    class GeneralHelper {
        
        public function generateRandomString ( $length = 8 ): string {
            $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen ( $characters );
            $randomString     = '';
            for ( $i = 0; $i < $length; $i++ ) {
                $randomString .= $characters[ rand ( 0, $charactersLength - 1 ) ];
            }
            return $randomString;
        }
        
        public function get_voucher_title ( $voucher_no ): string {
            $voucher = explode ( '-', $voucher_no );
            
            return match ( strtolower ( $voucher[ 0 ] ) ) {
                'cpv'   => 'Cash Payment Voucher',
                'crv'   => 'Cash Receipt Voucher',
                'bpv'   => 'Bank Payment Voucher',
                'brv'   => 'Bank Receipt Voucher',
                'jv'    => 'General Voucher',
                default => ''
            };
        }
        
        public function format_currency ( $num ) {
            
            if ( $num < 1 )
                return number_format ( $num, 2 );
            
            if ( $num > 1000 ) {
                
                $x               = round ( $num );
                $x_number_format = number_format ( $x );
                $x_array         = explode ( ',', $x_number_format );
                $x_parts         = array (
                    'k',
                    'm',
                    'b',
                    't'
                );
                $x_count_parts   = count ( $x_array ) - 1;
                $x_display       = $x;
                $x_display       = $x_array[ 0 ] . ( (int)$x_array[ 1 ][ 0 ] !== 0 ? '.' . $x_array[ 1 ][ 0 ] : '' );
                $x_display       .= $x_parts[ $x_count_parts - 1 ];
                
                return $x_display;
                
            }
            
            return $num;
        }
        
        public function format_date ( $date ): string {
            return date ( 'd-m-Y', strtotime ( $date ) );
        }
        
        public function format_date_time ( $date ): string {
            return date ( 'd-m-Y h:i A', strtotime ( $date . " +5 hours" ) );
        }
        
        function formatBytes ( $bytes, $precision = 2 ): string {
            $base     = log ( $bytes, 1024 );
            $suffixes = array ( '', 'K', 'M', 'G', 'T' );
            return round ( pow ( 1024, $base - floor ( $base ) ), $precision ) . ' ' . $suffixes[ floor ( $base ) ];
        }

        /**
         * Get the used credit (net closing) for an agent by account_head_id
         *
         * @param int $agent_account_head_id
         * @return float
         */
        public function getAgentUsedCredit($agent_account_head_id)
        {
            $accountService = new \App\Services\AccountService();
            $generalLedgerService = new \App\Services\GeneralLedgerService();
            $account_heads = $accountService->getRecursiveAccountHeads($agent_account_head_id);
            $parent_account_head = $accountService->get_account_head_by_id($agent_account_head_id);
            $account_head = [];
            $account_head[] = $parent_account_head;
            $account_heads_list = array_merge($account_head, $account_heads);
            $ledgers = $generalLedgerService->build_ledgers_table($account_heads_list);
            return $ledgers['net_closing'] ?? 0;
        }
    }