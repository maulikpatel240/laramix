<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class EventOrganiser extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_organiser';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'event_id',
        'member_id',
        'family_id',
        'society_id',
        'organiser'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'event_id',
        'member_id',
        'family_id',
        'society_id'
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

    public function family()
    {
        $witharray = ['mainmember'];
        return $this->hasOne(Family::class, 'id', 'family_id')->with($witharray)->whereHas('mainmember')->select(['id', 'house_number']);
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
