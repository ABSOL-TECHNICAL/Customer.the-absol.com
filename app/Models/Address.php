<?php

namespace App\Models;

// use Attribute;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_name',
        'address_1',
        'address_2',
        'address_3',
        'address_4',
        'latitude',
        'longitude',
        'location_type',
        'site_name',
        'country_id',
        'nearest_landmark',
        'companylandline_number',
        'postal_code',
        'payment_mode',
        'customer_id',
        'kenya_cities_id',
        'territory_id',
        'customer_site_synced',
    ];

    // protected $appends = [
    //     'location',
    // ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function KenyaCities(): BelongsTo
    {
        return $this->belongsTo(KenyaCities::class);
    }  
    public function Territory(): BelongsTo
    {
        return $this->belongsTo(Territory::class);
    }  

}
