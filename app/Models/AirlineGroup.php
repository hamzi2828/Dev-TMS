<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Segment;
use App\Models\Airline;
use App\Models\section;
use App\Models\Agent; // Assuming your travel agents are stored in `capl_agents` and model is `Agent`
use Illuminate\Console\View\Components\Secret;

class AirlineGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'airline_id',
        'sector_id',
        'company_id',
        'basic_per_adult',
        'tax_per_adult',
        'cost_per_adult',
        'sale_per_adult',
        'basic_per_child',
        'tax_per_child',
        'cost_per_child',
        'sale_per_child',
        'basic_per_infant',
        'tax_per_infant',
        'cost_per_infant',
        'sale_per_infant',
        'total_seats',
        'admin_seats',
        'travel_agent_id',
        'travel_agent_seats',
    ];

    /**
     * A group has many segments.
     */
    public function segments()
    {
        return $this->hasMany(Segment::class, 'airline_group_id');
    }

    /**
     * A group belongs to an airline.
     */
    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function my_bookings()
    {
        return $this->hasMany(MyBooking::class, 'airline_group_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'sector_id');
    }
}
