<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'general_ledgers', function ( Blueprint $table ) {
                $column = Schema ::hasColumn ( 'general_ledgers', 'invoice_no' );
                
                if ( !$column )
                    $table -> string ( 'invoice_no' ) -> nullable () -> after ( 'account_head_id' );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'general_ledgers', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'invoice_no' ] );
            } );
        }
    };
