<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Setting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'value',
        'is_active',
        'is_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active_at' => 'datetime',
    ];


    public function state()
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }

    public function district()
    {
        return $this->hasMany(District::class, 'country_id', 'id');
    }

    public function subdistrict()
    {
        return $this->hasMany(SubDistrict::class, 'country_id', 'id');
    }

    public function block()
    {
        return $this->hasMany(Block::class, 'country_id', 'id');
    }

    public function village()
    {
        return $this->hasMany(Village::class, 'country_id', 'id');
    }
}
