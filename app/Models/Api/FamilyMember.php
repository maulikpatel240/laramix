<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FamilyMember extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'family_member';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'family_id',
        'member_id',
        'type',
        'main_person',
        'is_active',
        'is_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'member_id',
        'family_id',
        'type',
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

    public function family()
    {
        $withArray = [
            'country:id,name',
            'state:id,name',
            'district:id,name',
            'subdistrict:id,name',
            'village:id,name',
            'society:id,name',
            'owner:id,first_name,last_name,phone_number',
        ];
        return $this->hasOne(Family::class, 'id', 'family_id')->with($withArray);
        // return $this->belongsTo(Family::class);
    }
    public function member()
    {
        return $this->hasOne(User::class, 'id', 'member_id');
    }
}
