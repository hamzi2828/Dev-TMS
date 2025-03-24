<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> foreignId ( 'tc_job_id' ) -> nullable () -> after ( 'job_id' );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'tc_job_id' ] );
            } );
        }
    };
