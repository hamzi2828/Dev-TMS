<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_tickets', function ( Blueprint $table ) {
                $table -> string ( 'pnr' ) -> after ( 'flight_no' ) -> nullable ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_tickets', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'pnr' ] );
            } );
        }
    };
