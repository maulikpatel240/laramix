<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class State extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'state';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'country_id',
        'name',
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
        'is_active',
        'is_active_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active_at' => 'datetime',
    ];

    public function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => UtcToLocal($value),
        );
    }
    public function updatedAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => UtcToLocal($value),
        );
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function district()
    {
        return $this->hasMany(District::class, 'state_id', 'id');
    }

    public function subdistrict()
    {
        return $this->hasMany(SubDistrict::class, 'state_id', 'id');
    }

    public function block()
    {
        return $this->hasMany(Block::class, 'state_id', 'id');
    }

    public function village()
    {
        return $this->hasMany(Village::class, 'state_id', 'id');
    }

    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => __("state." . $value),
        );
    }
}
