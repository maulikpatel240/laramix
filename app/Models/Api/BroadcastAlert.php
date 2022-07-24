<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BroadcastAlert extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'broadcast_alert';
    protected $appends = ['storage_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'broadcast_id',
        'broadcast_type',
        'member_id',
        'family_id',
        'state_id',
        'district_id',
        'village_id',
        'society_id',
        'group_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'broadcast_id',
        'member_id',
        'family_id',
        'state_id',
        'district_id',
        'village_id',
        'society_id',
        'group_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

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

    public function getStorageUrlAttribute()
    {
        return $this->attributes['storage_url'] = asset('storage');
    }

    public function broadcast()
    {
        return $this->hasOne(Broadcast::class, 'id', 'country_id');
    }

    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    public function village()
    {
        return $this->hasOne(Village::class, 'id', 'village_id');
    }

    public function society()
    {
        return $this->hasOne(Society::class, 'id', 'society_id');
    }

    public function family()
    {
        return $this->hasOne(Family::class, 'id', 'family_id');
    }

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function member()
    {
        return $this->hasOne(User::class, 'id', 'member_id');
    }
}
