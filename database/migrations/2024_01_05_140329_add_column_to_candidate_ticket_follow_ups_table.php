<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_ticket_follow_ups', function ( Blueprint $table ) {
                $table -> string ( 'status' ) -> default ( 'not-informed' ) -> nullable () -> after ( 'candidate_id' );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_ticket_follow_ups', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'status' ] );
            } );
        }
    };
