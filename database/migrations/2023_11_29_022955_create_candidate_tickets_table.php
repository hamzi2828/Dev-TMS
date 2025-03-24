<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'candidate_tickets', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'candidate_id' );
                $table -> string ( 'ticket_no' ) -> nullable ();
                $table -> string ( 'flight_no' ) -> nullable ();
                $table -> date ( 'dept_date' ) -> nullable ();
                $table -> time ( 'dept_time' ) -> nullable ();
                $table -> string ( 'status' ) -> nullable ();
                $table -> string ( 'file' ) -> nullable ();
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'candidate_id' ) -> on ( 'candidates' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'candidate_tickets' );
        }
    };
