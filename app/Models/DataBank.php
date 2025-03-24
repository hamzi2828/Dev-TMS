<?php
    
    namespace App\Models;
    
    use App\Services\GeneralService;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class DataBank extends Model {
        use HasFactory, SoftDeletes;
        
        protected $guarded = [];
        
        public function user (): BelongsTo {
            return $this -> belongsTo ( User::class );
        }
        
        public function createdAt (): string {
            return ( new GeneralService() ) -> date_formatter ( $this -> created_at );
        }
        
        public function fullName (): string {
            return $this -> first_name . ' ' . $this -> last_name;
        }
        
        public function job (): BelongsTo {
            return $this -> belongsTo ( Job::class );
        }
        
        public function qualification (): BelongsTo {
            return $this -> belongsTo ( Qualification::class );
        }
        
        public function country (): BelongsTo {
            return $this -> belongsTo ( Country::class );
        }
        
        public function city (): BelongsTo {
            return $this -> belongsTo ( City::class );
        }
        
        public function source (): BelongsTo {
            return $this -> belongsTo ( LeadSource::class );
        }
        
        public function referral (): BelongsTo {
            return $this -> belongsTo ( Referral::class );
        }
    }
