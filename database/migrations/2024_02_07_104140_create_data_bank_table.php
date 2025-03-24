<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'data_banks', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'job_id' ) -> nullable ();
                $table -> foreignId ( 'qualification_id' ) -> nullable ();
                $table -> foreignId ( 'country_id' ) -> nullable ();
                $table -> foreignId ( 'city_id' ) -> nullable ();
                $table -> foreignId ( 'lead_source_id' ) -> nullable ();
                $table -> foreignId ( 'referral_id' ) -> nullable ();
                $table -> string ( 'first_name' ) -> index ();
                $table -> string ( 'last_name' ) -> index ();
                $table -> string ( 'father_name' ) -> nullable () -> index ();
                $table -> string ( 'mother_name' ) -> nullable () -> index ();
                $table -> string ( 'mobile' ) -> nullable () -> index ();
                $table -> string ( 'alt_no' ) -> nullable () -> index ();
                $table -> string ( 'cnic' ) -> nullable () -> index ();
                $table -> date ( 'cnic_expiry_date' ) -> nullable ();
                $table -> date ( 'dob' ) -> nullable ();
                $table -> string ( 'passport' ) -> nullable () -> index ();
                $table -> date ( 'passport_issue_date' ) -> nullable ();
                $table -> date ( 'passport_expiry_date' ) -> nullable ();
                $table -> foreignId ( 'passport_issue_country_id' ) -> nullable ();
                $table -> string ( 'religion' ) -> nullable ();
                $table -> string ( 'marital_status' ) -> nullable ();
                $table -> integer ( 'age' ) -> nullable ();
                $table -> string ( 'gender' ) -> nullable ();
                $table -> string ( 'blood_group' ) -> nullable ();
                $table -> foreignId ( 'province_id' ) -> nullable ();
                $table -> foreignId ( 'district_id' ) -> nullable ();
                $table -> string ( 'address' ) -> nullable ();
                $table -> string ( 'next_of_kin' ) -> nullable ();
                $table -> string ( 'next_of_cnic' ) -> nullable ();
                $table -> string ( 'kin_relationship' ) -> nullable ();
                $table -> string ( 'contact_no' ) -> nullable ();
                $table -> string ( 'shirt_size' ) -> nullable ();
                $table -> string ( 'trouser_size' ) -> nullable ();
                $table -> string ( 'shoes_size' ) -> nullable ();
                $table -> float ( 'weight' ) -> nullable ();
                $table -> float ( 'height' ) -> nullable ();
                $table -> string ( 'email' ) -> nullable ();
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'job_id' ) -> on ( 'jobs' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'qualification_id' ) -> on ( 'qualifications' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'city_id' ) -> on ( 'cities' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'lead_source_id' ) -> on ( 'lead_sources' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'referral_id' ) -> on ( 'referrals' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'province_id' ) -> on ( 'provinces' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'district_id' ) -> on ( 'districts' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'passport_issue_country_id' ) -> on ( 'countries' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'country_id' ) -> on ( 'countries' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'data_banks' );
        }
    };
