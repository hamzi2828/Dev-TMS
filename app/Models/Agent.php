<?php

    namespace App\Models;

    use App\Services\GeneralService;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\MorphMany;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Agent extends Model {
        use HasFactory, SoftDeletes;

        protected $guarded = [];

        public function user (): BelongsTo {
            return $this -> belongsTo ( User::class );
        }

        public function createdAt (): string {
            return ( new GeneralService() ) -> date_formatter ( $this -> created_at );
        }

        public function general_ledger (): MorphMany {
            return $this -> morphMany ( GeneralLedger::class, 'ledgerable' );
        }
    }
