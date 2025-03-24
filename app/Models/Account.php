<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\MorphMany;
    use Illuminate\Database\Eloquent\Relations\MorphOne;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Carbon;
    
    class Account extends Model {
        use HasFactory, SoftDeletes;
        
        protected $guarded = [];
        protected $table   = 'account_heads';
        
        public function logs (): MorphMany {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
        public function account_head (): BelongsTo {
            return $this -> belongsTo ( Account::class );
        }
        
        public function account_type (): BelongsTo {
            return $this -> belongsTo ( AccountType::class );
        }
        
        public function candidate (): BelongsTo {
            return $this -> belongsTo ( Candidate::class, 'id', 'account_head_id' );
        }
        
        public function general_ledger (): MorphOne {
            return $this -> morphOne ( GeneralLedger::class, 'ledgerable' );
        }
        
        public function trial_balance (): HasMany {
            $relation = $this -> hasMany ( GeneralLedger::class, 'account_head_id' );
            if ( request () -> filled ( 'start-date' ) && request ( 'end-date' ) ) {
                $start_date = Carbon ::createFromFormat ( 'Y-m-d', request ( 'start-date' ) );
                $end_date   = Carbon ::createFromFormat ( 'Y-m-d', request ( 'end-date' ) );
                
                $relation -> whereBetween ( 'transaction_date', [
                    $start_date,
                    $end_date
                ] );
                
            }
            return $relation;
        }
        
        public function running_balance (): HasMany {
            $relation = $this -> hasMany ( GeneralLedger::class, 'account_head_id' );
            if ( request () -> filled ( 'start-date' ) ) {
                $start_date = Carbon ::createFromFormat ( 'Y-m-d', request ( 'start-date' ) );
                $relation -> where ( 'transaction_date', '<', $start_date );
            }
            return $relation;
        }
    }
