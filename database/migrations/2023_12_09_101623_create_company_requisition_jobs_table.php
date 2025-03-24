<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'company_requisition_jobs', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'company_requisition_id' );
                $table -> foreignId ( 'job_id' );
                $table -> integer ( 'quota' );
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'company_requisition_id' ) -> on ( 'company_requisitions' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'job_id' ) -> on ( 'jobs' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'company_requisition_jobs' );
        }
    };
