<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Group extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group';
    protected $appends = ['photo_url', 'isTotalGroupMember'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'typeofcategory_id',
        'country_id',
        'state_id',
        'district_id',
        'subdistrict_id',
        'village_id',
        'society_id',
        'owner_id',
        'name',
        'photo',
        'about',
        'type',
        'upi',
        'bank_name',
        'bank_account_number',
        'bank_ifsc_code',
        'bank_holder_name',
        'division',
        'is_active',
        'is_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'typeofcategory_id',
        'country_id',
        'state_id',
        'district_id',
        'subdistrict_id',
        'village_id',
        'society_id',
        'owner_id',
        'is_active',
        'is_active_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active_at' => 'datetime',
    ];

    public function getPhotoUrlAttribute()
    {
        $photo_url = asset('storage/group');
        return $this->attributes['photo_url'] = $this->photo ? $photo_url . '/' . $this->photo : "";
    }
    public function getIsTotalGroupMemberAttribute()
    {
        return $this->attributes['isTotalGroupMember'] = GroupMember::where('group_id', $this->id)->count();
    }
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
        return $this->hasOne(Typeofcategory::class, 'id', 'typeofcategory_id')->select(['id', 'category_id', 'type'])->with($witharray)->where('type', 'Group');
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

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public function groupmember()
    {
        return $this->hasMany(GroupMember::class, 'group_id', 'id')->select(['id', 'group_id', 'is_request']);
    }
}
