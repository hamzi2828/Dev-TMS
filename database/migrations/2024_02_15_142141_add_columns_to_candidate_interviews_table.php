<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_interviews', function ( Blueprint $table ) {
                $table -> string ( 'diagnostic' ) -> nullable () -> after ( 'candidate_id' );
                $table -> string ( 'writing' ) -> nullable () -> after ( 'diagnostic' );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_interviews', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'diagnostic', 'writing' ] );
            } );
        }
    };
