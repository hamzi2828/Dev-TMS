<?php
    
    namespace App\Models;
    
    use App\Services\GeneralService;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\HasOne;
    use Illuminate\Database\Eloquent\Relations\MorphMany;
    use Illuminate\Database\Eloquent\Relations\MorphOne;
    use Illuminate\Database\Eloquent\Relations\MorphTo;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class Candidate extends Model {
        use HasFactory, SoftDeletes;
        
        protected $guarded = [];
        
        public function user (): BelongsTo {
            return $this -> belongsTo ( User::class );
        }
        
        public function createdAt (): string {
            return ( new GeneralService() ) -> date_formatter ( $this -> created_at );
        }
        
        public function SerialNo (): string {
            return ( env ( 'APP_NAME' ) . '-' . $this -> sr_no );
        }
        
        public function cities (): HasMany {
            return $this -> hasMany ( City::class );
        }
        
        public function fullName (): string {
            return $this -> first_name . ' ' . $this -> last_name;
        }
        
        public function job (): BelongsTo {
            return $this -> belongsTo ( Job::class );
        }
        
        public function fee (): BelongsTo {
            return $this -> belongsTo ( Fee::class );
        }
        
        public function qualification (): BelongsTo {
            return $this -> belongsTo ( Qualification::class );
        }
        
        public function bank (): BelongsTo {
            return $this -> belongsTo ( Bank::class );
        }
        
        public function payment_method (): BelongsTo {
            return $this -> belongsTo ( PaymentMethod::class );
        }
        
        public function country (): BelongsTo {
            return $this -> belongsTo ( Country::class );
        }
        
        public function issue_place (): BelongsTo {
            return $this -> belongsTo ( Country::class, 'passport_issue_country_id' );
        }
        
        public function city (): BelongsTo {
            return $this -> belongsTo ( City::class );
        }
        
        public function source (): BelongsTo {
            return $this -> belongsTo ( LeadSource::class );
        }
        
        public function document (): HasOne {
            return $this -> hasOne ( CandidateDocument::class );
        }
        
        public function interview (): HasOne {
            return $this -> hasOne ( CandidateInterview::class );
        }
        
        public function medical (): HasOne {
            return $this -> hasOne ( CandidateMedical::class );
        }
        
        public function transactions (): HasMany {
            return $this -> hasMany ( GeneralLedger::class, 'account_head_id', 'account_head_id' );
        }
        
        public function visa (): HasOne {
            return $this -> hasOne ( CandidateVisa::class );
        }
        
        public function ticket (): HasOne {
            return $this -> hasOne ( CandidateTicket::class );
        }
        
        public function protector (): HasOne {
            return $this -> hasOne ( CandidateProtector::class );
        }
        
        public function general_ledger (): MorphMany {
            return $this -> morphMany ( GeneralLedger::class, 'ledgerable' );
        }
        
        public function requisition (): HasOne {
            return $this -> hasOne ( CandidateCompanyRequisitionJob::class );
        }
        
        public function document_ready (): HasOne {
            return $this -> hasOne ( CandidateDocumentReady::class );
        }
        
        public function province (): BelongsTo {
            return $this -> belongsTo ( Province::class );
        }
        
        public function district (): BelongsTo {
            return $this -> belongsTo ( District::class );
        }
        
        public function back_out (): HasOne {
            return $this -> hasOne ( CandidateBackOut::class );
        }
        
        public function principal (): BelongsTo {
            return $this -> belongsTo ( Principal::class );
        }
        
        public function payment_follow_up (): HasOne {
            return $this -> hasOne ( CandidatePaymentFollowUp::class );
        }
        
        public function visa_follow_up (): HasOne {
            return $this -> hasOne ( CandidateVisaFollowUp::class );
        }
        
        public function ticket_follow_up (): HasOne {
            return $this -> hasOne ( CandidateTicketFollowUp::class );
        }
        
        public function payment_receipt (): HasOne {
            return $this -> hasOne ( CandidatePaymentReceipt::class );
        }
        
        public function referral (): BelongsTo {
            return $this -> belongsTo ( Referral::class );
        }
        
        public function scopeActive ( $model ) {
            return $model -> where ( [ 'active' => '1' ] );
        }
        
        public function srNo (): string {
            return env ( 'APP_NAME' ) . '-' . $this -> sr_no;
        }
        
        public function medicalPayment (): MorphOne {
            return $this -> morphOne ( GeneralLedger::class, 'ledgerable' );
        }
    }
