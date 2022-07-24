<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BlogComment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog_comment';
    protected $appends = ['total_like'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'blog_id',
        'member_id',
        'text'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'blog_id',
        'member_id'
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

    public function blog()
    {
        return $this->hasOne(Blog::class, 'id', 'blog_id')->select(['id']);
    }

    public function member()
    {
        return $this->hasOne(User::class, 'id', 'member_id')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }

    public function blog_comment_reply()
    {
        $witharray = [
            'member'
        ];
        return $this->hasMany(BlogCommentReply::class, 'blog_comment_id', 'id')->with($witharray);
    }

    public function totalLike(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => BlogCommentLike::where(['blog_comment_id' => $attributes['id']])->count(),
        );
    }
}
