<?php
    
    namespace App\Models;
    
    use App\Services\GeneralService;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class CandidateCompanyRequisitionJob extends Model {
        use HasFactory;
        
        protected $guarded = [];
        
        public function user (): BelongsTo {
            return $this -> belongsTo ( User::class );
        }
        
        public function company_requisition_job (): BelongsTo {
            return $this -> belongsTo ( CompanyRequisitionJob::class );
        }
        
        public function fullName (): string {
            return $this -> code . ' - ' . $this -> title;
        }
        
        public function createdAt (): string {
            return ( new GeneralService() ) -> date_formatter ( $this -> created_at );
        }
    }
