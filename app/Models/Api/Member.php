<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Member extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';

    protected $appends = ['storage_url'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'role_id',
        'panel',
        'auth_key',
        'username',
        'first_name',
        'last_name',
        'middle_name',
        'gender',
        'date_of_birth',
        'aadhaar_card_number',
        'aadhaar_card_front_photo',
        'aadhaar_card_back_photo',
        'is_login',
        'phone_number',
        'phone_number_otp',
        'phone_number_verified',
        'phone_number_verified_at',
        'password',
        'email',
        'email_otp',
        'email_verified',
        'email_verified_at',
        'profile_photo',
        'nri',
        'nri_address',
        'nri_pincode',
        'pan_card_front_photo',
        'pan_card_back_photo',
        'education',
        'education_year',
        'timezone',
        'is_active',
        'is_active_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'auth_key',
        'password',
        'remember_token',
        'role_id',
        'is_login',
        'pivot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'phone_number_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
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
    // public function phoneNumber(): Attribute
    // {
    //     return new Attribute(
    //         get: fn ($value) => $this->phonevalidate($value),
    //     );
    // }
    // public function phonevalidate($value)
    // {
    //     $phone_number =  explode('-', $value);
    //     $number['code'] = count($phone_number) === 2 ? reset($phone_number) : $value;
    //     $number['mobile_number'] = count($phone_number) === 2 ? end($phone_number) : $value;
    //     $number['code_with_mobile_number'] = $value;
    //     return $number;
    // }

    public function getStorageUrlAttribute()
    {
        return $this->attributes['storage_url'] = asset('storage');
    }



    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function family()
    {
        $withArray = [
            'country:id,name',
            'state:id,name',
            'district:id,name',
            'subdistrict:id,name',
            'village:id,name',
            'society:id,name'
        ];
        return $this->belongsToMany(Family::class, 'family_member', 'member_id', 'family_id')->with($withArray)->withPivot('id')->latest();
    }
}
