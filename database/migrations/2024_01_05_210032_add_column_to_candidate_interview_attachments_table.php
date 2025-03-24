<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_interview_attachments', function ( Blueprint $table ) {
                $table -> string ( 'ept_back' ) -> after ( 'ept' ) -> nullable ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_interview_attachments', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'ept_back' ] );
            } );
        }
    };
