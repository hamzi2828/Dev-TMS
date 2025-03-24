<?php
    
    namespace App\Models;
    
    use App\Services\GeneralService;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    
    class CandidatePaymentFollowUp extends Model {
        use HasFactory;
        
        protected $guarded = [];
        
        public function user (): BelongsTo {
            return $this -> belongsTo ( User::class );
        }
        
        public function createdAt (): string {
            return ( new GeneralService() ) -> date_formatter ( $this -> created_at );
        }
        
        public function updatedAt (): string {
            return ( new GeneralService() ) -> date_formatter ( $this -> updated_at );
        }
    }
