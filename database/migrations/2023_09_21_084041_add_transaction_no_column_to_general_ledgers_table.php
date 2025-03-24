<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'general_ledgers', function ( Blueprint $table ) {
                $table -> string ( 'transaction_no' ) -> after ( 'payment_mode' ) -> nullable ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'general_ledgers', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'transaction_no' ] );
            } );
        }
    };
