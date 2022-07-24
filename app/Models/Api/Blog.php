<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Blog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog';

    protected $appends = ['storage_url', 'total_like', 'total_dislike'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'typeofcategory_id',
        'created_by',
        'title',
        'image',
        'video',
        'keywords',
        'description',
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
        'created_by',
        'is_active',
        'is_active_at'
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
    public function getStorageUrlAttribute()
    {
        return $this->attributes['storage_url'] = asset('storage');
    }
    public function typeofcategory()
    {
        $witharray = [
            'category:id,name,parent'
        ];
        return $this->hasOne(Typeofcategory::class, 'id', 'typeofcategory_id')->select(['id', 'category_id', 'type'])->with($witharray)->where('type', 'Blog');
    }

    public function createdby()
    {
        return $this->hasOne(User::class, 'id', 'created_by')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }

    public function totalLike(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => BlogLike::where(['blog_id' => $attributes['id'], 'is_like' => 1])->count(),
        );
    }
    public function totalDislike(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => BlogLike::where(['blog_id' => $attributes['id'], 'is_like' => 2])->count(),
        );
    }
}
