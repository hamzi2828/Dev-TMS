<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Segment;

class AirlineGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'airline_id',
        'sector_id'
    ];

    /**
     * A group has many segments.
     */
    public function segments()
    {
        return $this->hasMany(Segment::class, 'airline_group_id');
    }



    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

}
