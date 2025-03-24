<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> integer ( 'free_candidate' ) -> default ( '0' ) -> nullable () -> after ( 'proceed_to_visa' );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'free_candidate' ] );
            } );
        }
    };
