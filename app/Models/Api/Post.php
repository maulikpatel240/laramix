<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post';
    protected $appends = ['storage_url', 'total_like'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'post_id',
        'created_by',
        'group_id',
        'event_id',
        'blog_id',
        'job_id',
        'product_id',
        'offer_id',
        'book_id',
        'business_id',
        'color_id',
        'post_text',
        'post_link',
        'post_link_title',
        'post_link_image',
        'post_link_content',
        'post_photo',
        'post_video',
        'post_document',
        'post_record',
        'post_vimeo',
        'post_dailymotion',
        'post_facebook',
        'post_youtube',
        'post_vine',
        'post_sound_cloud',
        'post_playtube',
        'post_deepsound',
        'post_map',
        'post_share',
        'post_privacy',
        'post_type',
        'is_multi',
        'stream_name',
        'live_time',
        'live_ended',
        'post_url',
        'blur',
        'is_active',
        'is_active_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created_by',
        'group_id',
        'event_id',
        'blog_id',
        'job_id',
        'product_id',
        'offer_id',
        'book_id',
        'color_id',
        'is_active',
        'is_active_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'post_photo' => 'array',
        'post_video' => 'array',
        'post_document' => 'array',
        'is_active_at' => 'datetime',
    ];

    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => UtcToLocal($value),
        );
    }
    protected function updatedAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => UtcToLocal($value),
        );
    }

    protected function postText(): Attribute
    {
        return new Attribute(
            set: fn ($value) => $value,
            get: fn ($value) => $this->gettext($value),
        );
    }

    public function gettext($value)
    {
        return Markup($value, true, true, true, $this->id);
    }

    public function hasreturn($value)
    {
    }
    public function getStorageUrlAttribute()
    {
        return $this->attributes['storage_url'] = asset('storage');
    }

    public function createdby()
    {
        return $this->hasOne(User::class, 'id', 'created_by')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }

    public function color()
    {
        return $this->hasOne(Colored::class, 'id', 'color_id')->select(['id', 'color', 'text_color', 'bg_image']);
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
        $field = ['id', 'division', 'typeofcategory_id', 'country_id', 'state_id', 'district_id', 'subdistrict_id', 'village_id', 'society_id', 'owner_id', 'name', 'photo', 'about', 'type', 'created_at', 'updated_at'];
        return $this->hasOne(Group::class, 'id', 'group_id')->select($field)->with($withArray)->where('type', 'public')->orWhere(function ($query) {
            return $query->where('type', 'private')->whereHas('groupmember', function ($q) {
                $q->where('member_id', auth()->user()->id);
            });
        });
    }

    public function event()
    {
        $withArray = [
            'typeofcategory',
            // 'user',
        ];
        $field = ['id', 'typeofcategory_id', 'created_by', 'title', 'datetype', 'start_date', 'end_date', 'start_time', 'end_time', 'allow_end_date', 'location', 'organiser', 'event_invitation_type'];
        return $this->hasOne(Event::class, 'id', 'event_id')->select($field)->with($withArray)->whereHas('eventinvitation', function ($q) {
            $q->where(['event_invitation_type' => 'Village', 'village_id' => User::find(auth()->user()->id)->family[0]->village->id])
                ->orWhere(['event_invitation_type' => 'Society', 'society_id' => User::find(auth()->user()->id)->family[0]->society->id])
                ->orWhere(['event_invitation_type' => 'Member', 'member_id' => auth()->user()->id]);
        });
    }

    public function blog()
    {
        $withArray = [
            'typeofcategory',
            // 'user',
        ];
        $field = ['id', 'typeofcategory_id', 'created_by', 'title', 'keywords', 'image', 'video', 'description'];
        return $this->hasOne(Blog::class, 'id', 'blog_id')->select($field)->with($withArray);
    }
    public function job()
    {
        $withArray = [
            'typeofcategory',
            // 'user',
        ];
        $field = ['id', 'typeofcategory_id', 'created_by', 'title', 'type', 'education', 'experience', 'option', 'option_name', 'option_website', 'option_address', 'option_email', 'option_phone_number', 'is_closed'];
        return $this->hasOne(Job::class, 'id', 'job_id')->select($field)->with($withArray);
    }
    public function product()
    {
        $withArray = [
            'typeofcategory',
            // 'user',
        ];
        $field = ['id', 'typeofcategory_id', 'created_by', 'type', 'name', 'image', 'video', 'price', 'max_retail_price', 'product_type', 'property_type', 'area', 'pincode', 'address', 'is_sale'];
        return $this->hasOne(Product::class, 'id', 'product_id')->select($field)->with($withArray);
    }
    public function offer()
    {
        $withArray = [
            // 'typeofcategory',
            // 'user',
        ];
        $field = ['id', 'typeofcategory_id', 'created_by', 'title', 'description', 'image', 'video', 'start_date', 'end_date', 'promocode'];
        return $this->hasOne(Offer::class, 'id', 'offer_id')->select($field)->with($withArray);
    }
    public function book()
    {
        $withArray = [
            'typeofcategory',
            // 'user',
        ];
        $field = ['id', 'typeofcategory_id', 'created_by', 'title', 'edition', 'book_pdf', 'price_type', 'price', 'website', 'language', 'publisher_type', 'publishing_date'];
        return $this->hasOne(Book::class, 'id', 'book_id')->select($field)->with($withArray);
    }
    public function totalLike(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => PostLike::where(['post_id' => $attributes['id'], 'is_like' => 1])->count(),
        );
    }
}
