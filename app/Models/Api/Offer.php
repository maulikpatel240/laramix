<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Offer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'offer';
    protected $appends = ['image_url', 'video_url'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'typeofcategory_id',
        'user_id',
        'title',
        'description',
        'image',
        'video',
        'start_date',
        'end_date',
        'promocode',
        'is_active',
        'is_active_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'typeofcategory_id',
        'user_id',
        'is_active',
        'is_active_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'array',
        'video' => 'array',
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
        return $this->hasOne(Typeofcategory::class, 'id', 'typeofcategory_id')->select(['id', 'category_id', 'type'])->with($witharray)->where('type', 'Product');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }
}
