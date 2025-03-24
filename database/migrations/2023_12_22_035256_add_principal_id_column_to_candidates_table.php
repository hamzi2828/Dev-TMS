<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> foreignId ( 'principal_id' ) -> nullable () -> after ( 'referral_id' );
                $table -> foreign ( 'principal_id' ) -> on ( 'principals' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'principal_id' ] );
            } );
        }
    };
