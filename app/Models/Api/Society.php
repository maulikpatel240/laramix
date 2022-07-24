<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Society extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'society';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'country_id',
        'state_id',
        'district_id',
        'subdistrict_id',
        'village_id',
        'religion_id',
        'logo',
        'name',
        'type',
        'headquarters',
        'chairman',
        'is_active',
        'is_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'country_id',
        'state_id',
        'district_id',
        'subdistrict_id',
        'village_id',
        'religion_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active_at' => 'datetime',
    ];

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }
    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }
    public function subdistrict()
    {
        return $this->hasOne(Subdistrict::class, 'id', 'subdistrict_id');
    }
    public function village()
    {
        return $this->hasOne(Village::class, 'id', 'village_id');
    }
    public function religion()
    {
        return $this->hasOne(Religion::class, 'id', 'religion_id');
    }

    // public function name(): Attribute
    // {
    //     return new Attribute(
    //         get: fn ($value) => __("society." . $value),
    //     );
    // }

}
