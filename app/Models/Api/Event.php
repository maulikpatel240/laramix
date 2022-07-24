<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Event extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'typeofcategory_id',
        'created_by',
        'country_id',
        'state_id',
        'district_id',
        'subdistrict_id',
        'village_id',
        'society_id',
        'area',
        'organiser_phone_number',
        'title',
        'datetype',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'allow_end_date',
        'location',
        'notes',
        'organiser',
        'event_invitation_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'typeofcategory_id',
        'created_by',
        'is_active',
        'is_active_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'organiser_phone_number' => 'array',
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

    public function typeofcategory()
    {
        $witharray = [
            'category:id,name,parent'
        ];
        return $this->hasOne(Typeofcategory::class, 'id', 'typeofcategory_id')->select(['id', 'category_id', 'type'])->with($witharray)->where('type', 'Event');
    }

    public function createdby()
    {
        return $this->hasOne(User::class, 'id', 'created_by')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }

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
        return $this->hasOne(SubDistrict::class, 'id', 'subdistrict_id');
    }

    public function village()
    {
        return $this->hasOne(Village::class, 'id', 'village_id');
    }

    public function society()
    {
        return $this->hasOne(Society::class, 'id', 'society_id');
    }

    public function eventinvitation()
    {
        return $this->hasMany(EventInvitation::class, 'event_id', 'id')->select(['id', 'event_id', 'village_id', 'society_id', 'group_id', 'user_id', 'event_invitation_type']);
    }

    public function eventOrganiser()
    {
        return $this->hasMany(EventOrganiser::class, 'id', 'event_id')->select(['id', 'event_id', 'family_id', 'member_id', 'society_id', 'group_id', 'organiser']);
    }
}
