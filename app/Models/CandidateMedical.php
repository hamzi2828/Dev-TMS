<?php
    
    namespace App\Models;
    
    use App\Services\GeneralService;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class CandidateMedical extends Model {
        use HasFactory, SoftDeletes;
        
        protected $guarded = [];
        
        public function user (): BelongsTo {
            return $this -> belongsTo ( User::class );
        }
        
        public function createdAt (): string {
            return ( new GeneralService() ) -> date_formatter ( $this -> created_at );
        }
        
        public function attachments (): HasMany {
            return $this -> hasMany ( CandidateMedicalAttachment::class );
        }
        
        public function fee (): BelongsTo {
            return $this -> belongsTo ( Fee::class );
        }
        
        public function vendor (): BelongsTo {
            return $this -> belongsTo ( Vendor::class );
        }
        
        public function payment_method (): BelongsTo {
            return $this -> belongsTo ( PaymentMethod::class );
        }
        
        public function updatedAt (): string {
            return ( new GeneralService() ) -> date_formatter ( $this -> updated_at );
        }
    }
