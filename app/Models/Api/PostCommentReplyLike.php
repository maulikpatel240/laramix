<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PostCommentReplyLike extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_comment_reply_like';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'post_comment_reply_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
        'post_comment_reply_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    public function postcommentreply()
    {
        return $this->hasOne(PostCommentReply::class, 'id', 'post_comment_reply_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }
}
