<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_document_ready', function ( Blueprint $table ) {
                $table -> foreignId ( 'agreement_id' ) -> nullable () -> after ( 'candidate_id' );
                $table -> foreign ( 'agreement_id' ) -> on ( 'agreements' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_document_ready', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'agreement_id' ] );
            } );
        }
    };
