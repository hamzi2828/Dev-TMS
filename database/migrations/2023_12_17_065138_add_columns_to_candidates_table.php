<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> after ( 'blood_group', function ( $table ) {
                    $table -> integer ( 'contract_period' ) -> nullable ();
                    $table -> string ( 'accommodation' ) -> nullable ();
                    $table -> string ( 'food' ) -> nullable ();
                    $table -> float ( 'salary' ) -> nullable ();
                    $table -> text ( 'address' ) -> nullable ();
                } );
                
                $table -> string ( 'next_of_kin_cnic' ) -> nullable () -> after ( 'next_of_kin' );
                $table -> foreignId ( 'passport_issue_country_id' ) -> nullable () -> after ( 'referral_id' );
                
                $table -> foreign ( 'passport_issue_country_id' ) -> on ( 'countries' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'contract_period', 'accommodation', 'food', 'salary', 'next_of_kin_cnic', 'passport_issue_country_id', 'address' ] );
            } );
        }
    };
