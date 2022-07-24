<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class GroupMember extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_member';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'group_id',
        'member_id',
        'captain',
        'wisecaptain',
        'is_request',
        'is_active',
        'is_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'group_id',
        'member_id',
        'is_active',
        'is_active_at',
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

    public function group()
    {
        $withArray = [
            'typeofcategory',
            'country:id,name',
            'state:id,name',
            'district:id,name',
            'subdistrict:id,name',
            'village:id,name',
            'society:id,name',
            'owner:id,first_name,last_name,phone_number',
        ];
        return $this->hasOne(Group::class, 'id', 'group_id')->select([
            'id',
            // 'division',
            // 'country_id',
            // 'state_id',
            // 'district_id',
            // 'subdistrict_id',
            // 'village_id',
            // 'society_id',
            // 'owner_id',
            'name',
            // 'photo',
            // 'about',
            // 'type',
            // 'created_at',
            // 'updated_at',
        ]);
    }

    public function member()
    {
        return $this->hasOne(User::class, 'id', 'member_id')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }
}
