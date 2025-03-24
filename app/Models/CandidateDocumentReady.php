<?php
    
    namespace App\Models;
    
    use App\Services\GeneralService;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class CandidateDocumentReady extends Model {
        use HasFactory, SoftDeletes;
        
        protected $guarded = [];
        protected $table = 'candidate_document_ready';
        
        public function user (): BelongsTo {
            return $this -> belongsTo ( User::class );
        }
        
        public function createdAt (): string {
            return ( new GeneralService() ) -> date_formatter ( $this -> created_at );
        }
        
        public function updatedAt (): string {
            return ( new GeneralService() ) -> date_formatter ( $this -> updated_at );
        }
        
        public function agreement (): BelongsTo {
            return $this -> belongsTo ( Agreement::class );
        }
    }
