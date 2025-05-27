<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\MorphMany;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class AccountType extends Model {
        use HasFactory;
        use SoftDeletes;

        protected $guarded = [];

        public function logs (): MorphMany {
            return $this -> morphMany ( Log::class, 'logable' );
        }
    }
