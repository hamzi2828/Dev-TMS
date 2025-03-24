<?php
    
    namespace Database\Seeders;
    
    use App\Models\LeadSource;
    use App\Models\User;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Carbon;
    
    class LeadSourceSeeder extends Seeder {
        
        public function run (): void {
            $user_id = User ::first () -> id;
            $source  = [
                [
                    'user_id'    => $user_id,
                    'title'      => 'Advertisement',
                    'slug'       => 'advertisement',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Cold Call',
                    'slug'       => 'cold-call',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Employee Referral',
                    'slug'       => 'employee-referral',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'External Referral',
                    'slug'       => 'external-referral',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Online Store',
                    'slug'       => 'online-store',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Twitter',
                    'slug'       => 'twitter',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Facebook',
                    'slug'       => 'facebook',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Instagram',
                    'slug'       => 'instagram',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Partner',
                    'slug'       => 'partner',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Google+',
                    'slug'       => 'google-plus',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Public Relations',
                    'slug'       => 'public-relations',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Sales Emails Alias',
                    'slug'       => 'sales-emails-alias',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Seminar Partner',
                    'slug'       => 'seminar-partner',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Internal Seminar',
                    'slug'       => 'internal-seminar',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Trade Show',
                    'slug'       => 'trade-show',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Web Search',
                    'slug'       => 'web-search',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => $user_id,
                    'title'      => 'Chat',
                    'slug'       => 'chat',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
            ];
            LeadSource ::insert ( $source );
        }
    }
