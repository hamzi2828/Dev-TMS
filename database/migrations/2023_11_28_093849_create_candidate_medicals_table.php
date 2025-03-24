<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'candidate_medicals', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'candidate_id' );
                $table -> foreignId ( 'payment_method_id' );
                $table -> float ( 'amount' ) -> nullable ();
                $table -> string ( 'transaction_no' ) -> nullable ();
                $table -> string ( 'status' ) -> nullable ();
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'candidate_id' ) -> on ( 'candidates' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'payment_method_id' ) -> on ( 'payment_methods' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'candidate_medicals' );
        }
    };
