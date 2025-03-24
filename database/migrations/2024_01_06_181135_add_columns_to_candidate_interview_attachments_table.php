<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_interview_attachments', function ( Blueprint $table ) {
                $table -> after ( 'experience', function ( $table ) {
                    $table -> string ( 'assessment_aptitude_front' ) -> nullable ();
                    $table -> string ( 'assessment_aptitude_back' ) -> nullable ();
                } );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_interview_attachments', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'assessment_aptitude_front', 'assessment_aptitude_back' ] );
            } );
        }
    };
