<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> foreignId ( 'province_id' ) -> nullable () -> after ( 'passport_issue_country_id' );
                $table -> foreignId ( 'district_id' ) -> nullable () -> after ( 'province_id' );
                
                $table -> foreign ( 'province_id' ) -> on ( 'provinces' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'district_id' ) -> on ( 'districts' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'province_id', 'district_id' ] );
            } );
        }
    };
