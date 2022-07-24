<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product';
    protected $appends = ['image_url', 'video_url'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'typeofcategory_id',
        'created_by',
        'type',
        'name',
        'sku',
        'image',
        'video',
        'price',
        'max_retail_price',
        'product_type',
        'property_type',
        'description',
        'area',
        'pincode',
        'address',
        'is_sale',
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

    public function image(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ? explode(',', $value) : null,
            set: fn ($value) => $value,
        );
    }
    public function getImageUrlAttribute()
    {
        return $this->attributes['image_url'] = $this->image ? $this->imageUrlArray($this->image) : null;
    }
    public function imageUrlArray($value)
    {
        $file = $value;
        $multiFileUrl = [];
        if ($file) {
            for ($i = 0; $i < count($file); $i++) {
                $file_url = asset('storage/product/image');
                $multiFileUrl[] = $file[$i] ? $file_url . '/' . $file[$i] : "";
            }
        }
        return count($multiFileUrl) ? $multiFileUrl : null;
    }
    public function getVideoUrlAttribute()
    {
        $file_url = asset('storage/product/video');
        return $this->attributes['video_url'] = $this->video ? $file_url . '/' . $this->video : null;
    }

    public function typeofcategory()
    {
        $witharray = [
            'category:id,name,parent'
        ];
        return $this->hasOne(Typeofcategory::class, 'id', 'typeofcategory_id')->select(['id', 'category_id', 'type'])->with($witharray)->where('type', 'Product');
    }

    public function createdby()
    {
        return $this->hasOne(User::class, 'id', 'created_by')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }
}
