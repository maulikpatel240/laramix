<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FamilyRelation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'family_relation';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'member_id',
        'created_by',
        'relation_id',
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
        'member_id',
        'created_by',
        'relation_id',
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

    public function member()
    {
        return $this->hasOne(User::class, 'id', 'member_id')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }
    public function createdby()
    {
        return $this->hasOne(User::class, 'id', 'created_by')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }
    public function relation()
    {
        return $this->hasOne(Relation::class, 'id', 'relation_id')->select(['id', 'name']);
    }
}
