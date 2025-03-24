<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_interviews', function ( Blueprint $table ) {
                $table -> integer ( 'status_update_count' ) -> default ( '0' ) -> nullable () -> after ( 'status' );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_interviews', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'status_update_count' ] );
            } );
        }
    };
