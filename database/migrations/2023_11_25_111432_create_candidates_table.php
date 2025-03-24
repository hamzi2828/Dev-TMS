<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'candidates', function ( Blueprint $table ) {
                $table -> id ();
                $table -> string ( 'sr_no' ) -> unique () -> index ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'job_id' );
                $table -> foreignId ( 'qualification_id' ) -> nullable ();
                $table -> foreignId ( 'bank_id' ) -> nullable ();
                $table -> foreignId ( 'payment_method_id' );
                $table -> foreignId ( 'country_id' ) -> nullable () -> comment ( 'Nationality' );
                $table -> foreignId ( 'city_id' ) -> nullable ();
                $table -> foreignId ( 'lead_source_id' ) -> nullable ();
                $table -> foreignId ( 'account_head_id' ) -> nullable ();
                $table -> string ( 'first_name' ) -> index ();
                $table -> string ( 'last_name' ) -> index ();
                $table -> string ( 'father_name' ) -> nullable () -> index ();
                $table -> string ( 'mother_name' ) -> nullable () -> index ();
                $table -> string ( 'mobile' ) -> nullable () -> index ();
                $table -> string ( 'alt_no' ) -> nullable () -> index ();
                $table -> string ( 'cnic' ) -> nullable () -> index ();
                $table -> string ( 'religion' ) -> nullable ();
                $table -> string ( 'marital_status' ) -> nullable ();
                $table -> integer ( 'age' ) -> nullable ();
                $table -> string ( 'gender' ) -> nullable ();
                $table -> string ( 'blood_group' ) -> nullable ();
                $table -> string ( 'passport' ) -> nullable () -> index ();
                $table -> date ( 'passport_issue_date' ) -> nullable ();
                $table -> date ( 'passport_expiry_date' ) -> nullable ();
                $table -> string ( 'next_of_kin' ) -> nullable ();
                $table -> string ( 'kin_relationship' ) -> nullable ();
                $table -> string ( 'contact_no' ) -> nullable ();
                $table -> string ( 'shirt_size' ) -> nullable ();
                $table -> string ( 'trouser_size' ) -> nullable ();
                $table -> string ( 'shoes_size' ) -> nullable ();
                $table -> float ( 'weight' ) -> nullable ();
                $table -> float ( 'height' ) -> nullable ();
                $table -> string ( 'email' ) -> nullable ();
                $table -> string ( 'account_no' ) -> nullable ();
                $table -> string ( 'transaction_no' ) -> unique () -> index ();
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'job_id' ) -> on ( 'jobs' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'qualification_id' ) -> on ( 'qualifications' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'bank_id' ) -> on ( 'banks' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'payment_method_id' ) -> on ( 'payment_methods' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'city_id' ) -> on ( 'cities' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'country_id' ) -> on ( 'countries' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'account_head_id' ) -> on ( 'account_heads' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'lead_source_id' ) -> on ( 'lead_sources' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'candidates' );
        }
    };
