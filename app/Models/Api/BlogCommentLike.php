<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BlogCommentLike extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog_comment_like';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'member_id',
        'blog_id',
        'blog_comment_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'member_id',
        'blog_id',
        'blog_comment_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    public function blogcoment()
    {
        return $this->hasOne(BlogComment::class, 'id', 'blog_comment_id');
    }

    public function blog()
    {
        return $this->hasOne(Blog::class, 'id', 'blog_id');
    }

    public function member()
    {
        return $this->hasOne(User::class, 'id', 'member_id')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }
}
