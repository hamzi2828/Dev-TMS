<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'candidate_company_requisition_jobs', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'candidate_id' );
                $table -> foreignId ( 'company_requisition_job_id' );
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'candidate_id', 'candidate' ) -> on ( 'candidates' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'company_requisition_job_id', 'company_requisition_job' ) -> on ( 'company_requisition_jobs' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'candidate_company_requisition_jobs' );
        }
    };
