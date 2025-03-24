<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_tickets', function ( Blueprint $table ) {
                $table -> float ( 'price' ) -> default ( 0 ) -> after ( 'dept_time' );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_tickets', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'price' ] );
            } );
        }
    };
