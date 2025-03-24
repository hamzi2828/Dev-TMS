<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> foreignId ( 'fee_id' ) -> after ( 'lead_source_id' );
                $table -> float ( 'amount' ) -> after ( 'transaction_no' );
                
                $table -> foreign ( 'fee_id' ) -> on ( 'fees' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'fee_id', 'amount' ] );
            } );
        }
    };
