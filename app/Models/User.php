<?php
    
    namespace App\Models;
    
    // use Illuminate\Contracts\Auth\MustVerifyEmail;
    use App\Services\GeneralService;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;
    
    class User extends Authenticatable {
        use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
        
        protected $guarded = [];
        protected $hidden  = [
            'password',
            'remember_token',
        ];
        protected $casts   = [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
        
        public function fullName (): string {
            return $this -> name;
        }
        
        public function company (): BelongsTo {
            return $this -> belongsTo ( Company::class );
        }
        
        public function agent(): BelongsTo { 
            return $this->belongsTo(Agent::class); 
        }
        
        public function createdAt (): string {
            return ( new GeneralService() ) -> date_formatter ( $this -> created_at );
        }
        
        public function image () {
            $url = asset('/assets/img/avatars/1.png');
            if ( !empty( trim ( $this -> image ) ) )
                $url = $this -> image;
            return $url;
        }
        
        public function roles (): array {
            return $this -> hasMany ( UserRole::class ) -> pluck ( 'role_id' ) -> toArray ();
        }
        
        public function is_admin (): bool {
            return in_array ( '1', $this -> roles() );
        }
        
        public function user_roles (): HasMany {
            return $this -> hasMany ( UserRole::class );
        }
        
        public function get_user_roles (): array {
            $this -> load ( [ 'user_roles.role' ] );
            $roles = array ();
            
            if ( count ( $this -> user_roles ) > 0 ) {
                foreach ( $this -> user_roles as $userRoles ) {
                    if ( !empty( $userRoles -> role ) ) {
                        $roles[] = $userRoles -> role -> title;
                    }
                }
            }
            return array_values ( array_unique ( $roles, SORT_REGULAR ) );
        }
        
        public function permissions (): array {
            $this -> load ( [ 'user_roles.role.permission' ] );
            $permissions = array ();
            
            if ( count ( $this -> user_roles ) > 0 ) {
                foreach ( $this -> user_roles as $userRoles ) {
                    if ( !empty( $userRoles -> role ) && count ( $userRoles -> role -> permission ) > 0 ) {
                        foreach ( $userRoles -> role -> permission as $permission ) {
                            $permissions[] = $permission -> permission;
                        }
                    }
                }
            }
            return $permissions;
        }
    }
