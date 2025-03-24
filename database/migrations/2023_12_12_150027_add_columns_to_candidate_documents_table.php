<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_documents', function ( Blueprint $table ) {
                $table -> string ( 'nicop_front' ) -> after ( 'cnic_front' ) -> nullable ();
                $table -> string ( 'nicop_back' ) -> after ( 'nicop_front' ) -> nullable ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_documents', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'nicop_front', 'nicop_back' ] );
            } );
        }
    };
