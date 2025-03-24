<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'candidate_documents', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'candidate_id' );
                $table -> string ( 'picture' ) -> nullable ();
                $table -> string ( 'passport' ) -> nullable ();
                $table -> string ( 'cnic_front' ) -> nullable ();
                $table -> string ( 'cnic_back' ) -> nullable ();
                $table -> timestamps ();
                
                $table -> foreign ( 'candidate_id' ) -> on ( 'candidates' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'candidate_documents' );
        }
    };
