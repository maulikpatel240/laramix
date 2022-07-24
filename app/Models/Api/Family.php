<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Family extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'family';
    protected $appends = ['storage_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'address_type',
        'parent_id',
        'country_id',
        'state_id',
        'district_id',
        'subdistrict_id',
        'village_id',
        'society_id',
        'owner_id',
        'caste_id',
        'area',
        'pincode',
        'location',
        'is_current_address',
        'family_identity_number',
        'house_number',
        'family_photo',
        'description',
        'type',
        'is_active',
        'is_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'parent_id',
        'country_id',
        'state_id',
        'district_id',
        'subdistrict_id',
        'village_id',
        'society_id',
        'caste_id',
        'owner_id',
        'pivot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'family_photo' => 'array',
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

    public function getStorageUrlAttribute()
    {
        return $this->attributes['storage_url'] = asset('storage');
    }

    public function other_address()
    {
        $withArray = [
            'country:id,name',
            'state:id,name',
            'district:id,name',
            'subdistrict:id,name',
            'village:id,name',
            'society:id,name',
            'caste:id,name',
        ];
        return $this->hasMany(Family::class, 'parent_id', 'id')->Select(["id", "parent_id", 'country_id', 'state_id', 'district_id', 'subdistrict_id', 'village_id', 'society_id', "address_type", "area", "pincode", "house_number", "is_current_address"])->with($withArray);
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

    public function caste()
    {
        return $this->hasOne(Caste::class, 'id', 'caste_id');
    }

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public function mainmember()
    {
        $witharray = ['user:id,first_name,last_name,phone_number'];
        return $this->belongsToMany(User::class, 'family_member', 'family_id', 'member_id')->select(['user.id', 'user.first_name', 'user.last_name', 'user.middle_name'])->withPivot('id')->where(['main_person' => 1]);
        // return $this->belongsToMany(Familymember::class, 'family_id', 'id')->with($witharray)->where(['main_person' => 1]);
    }
}
