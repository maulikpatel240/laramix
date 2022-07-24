<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class EventInvitation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_invitation';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'event_id',
        'village_id',
        'society_id',
        'group_id',
        'member_id',
        'event_invitation_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'event_id',
        'village_id',
        'society_id',
        'group_id',
        'member_id',
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

    public function event()
    {
        return $this->hasOne(Event::class, 'id', 'event_id')->select(['id']);
    }

    public function village()
    {
        $withArray = [
            'country:id,name',
            'state:id,name',
            'district:id,name',
            'subdistrict:id,name'
        ];
        return $this->hasOne(Village::class, 'id', 'village_id')->with($withArray)->select(['id', 'country_id', 'state_id', 'district_id', 'subdistrict_id', 'name']);
    }

    public function member()
    {
        return $this->hasOne(User::class, 'id', 'member_id')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }

    public function society()
    {
        return $this->hasOne(Society::class, 'id', 'society_id')->select(['id', 'name']);
    }

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id')->select(['id', 'name']);
    }
}
