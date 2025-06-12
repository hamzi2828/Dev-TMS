<?php
    
    namespace App\Models;
    
    use App\Services\GeneralService;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class Bank extends Model {
        use HasFactory, SoftDeletes;
        
        protected $fillable = [
            'user_id',
            'bank_name',
            'file',
            'bank_code',
            'bank_branch',
            'account_title',
            'account_number',
            'iban'
        ];
        
        public function createdAt (): string {
            return ( new GeneralService() ) -> date_formatter ( $this -> created_at );
        }
        
        public function user (): BelongsTo {
            return $this -> belongsTo ( User::class );
        }
    }
