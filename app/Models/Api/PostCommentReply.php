<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PostCommentReply extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_comment_reply';
    protected $appends = ['total_like'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'post_comment_id',
        'text'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'post_id',
        'user_id',
        'post_comment_id',
        'updated_at',
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
    public function postcomment()
    {
        return $this->hasOne(PostComment::class, 'id', 'post_comment_id');
    }

    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'post_id')->select(['id']);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }

    public function totalLike(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => PostCommentReplyLike::where(['post_comment_reply_id' => $attributes['id']])->count(),
            // get: fn ($value, $attributes) => $attributes,
        );
    }
}
