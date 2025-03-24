<?php
    
    namespace Database\Seeders;
    
    use App\Models\AccountType;
    use App\Models\User;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Carbon;
    
    class AccountTypeSeeder extends Seeder {
        
        public function run (): void {
            $info = [
                [
                    'user_id'    => User ::first () -> id,
                    'title'      => 'Expenditure',
                    'type'       => 'debit',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => User ::first () -> id,
                    'title'      => 'Income',
                    'type'       => 'credit',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => User ::first () -> id,
                    'title'      => 'Capital',
                    'type'       => 'credit',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => User ::first () -> id,
                    'title'      => 'Liability',
                    'type'       => 'credit',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
                [
                    'user_id'    => User ::first () -> id,
                    'title'      => 'Asset',
                    'type'       => 'debit',
                    'created_at' => Carbon ::now (),
                    'updated_at' => Carbon ::now (),
                ],
            ];
            AccountType ::insert ( $info );
        }
    }
