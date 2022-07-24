<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class JobInterest extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_interest';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'job_id',
        'member_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'job_id',
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

    public function job()
    {
        $withArray = [
            'typeofcategory',
            'createdby',
        ];
        return $this->hasOne(Job::class, 'id', 'job_id')->with($withArray)->select(['id', 'typeofcategory_id', 'created_by', 'title', 'option', 'option_name', 'option_address']);
    }

    public function member()
    {
        return $this->hasOne(User::class, 'id', 'member_id')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }
}
