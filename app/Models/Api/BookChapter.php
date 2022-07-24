<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BookChapter extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book_chapter';
    protected $appends = ['isEditChapter', 'isDeleteChapter', 'storage_url'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'book_id',
        'user_id',
        'chapter',
        'title',
        'text',
        'image',
        'video',
        'chapter_pdf',
        'is_active',
        'is_active_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'book_id',
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
        'chapter_pdf' => 'array',
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
    public function getIsEditChapterAttribute()
    {
        return $this->attributes['isCreateChapter'] = $this->user_id === auth()->user()->id ? 1 : 0;
    }
    public function getIsDeleteChapterAttribute()
    {
        return $this->attributes['isCreateChapter'] = $this->user_id === auth()->user()->id ? 1 : 0;
    }
    public function book()
    {
        return $this->hasOne(Book::class, 'id', 'book_id')->select(['id']);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }
}
