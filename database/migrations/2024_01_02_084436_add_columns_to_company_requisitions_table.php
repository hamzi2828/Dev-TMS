<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'company_requisitions', function ( Blueprint $table ) {
                $table -> foreignId ( 'principal_id' ) -> after ( 'user_id' ) -> nullable ();
                $table -> foreign ( 'principal_id' ) -> on ( 'principals' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'company_requisitions', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'principal_id' ] );
            } );
        }
    };
