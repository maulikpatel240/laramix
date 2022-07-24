<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Author extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'author';
    protected $append = ['photo_url'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'book_id',
        'user_id',
        'name',
        'photo',
        'description',
        'is_member',
        'is_active',
        'is_active_at',
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
    public function getPhotoUrlAttribute()
    {
        $photo_url = asset('storage/author');
        return $this->attributes['photo_url'] = $this->photo ? $photo_url . '/' . $this->photo : "";
    }
    public function book()
    {
        return $this->hasOne(Book::class, 'id', 'book_id')->select(['id', 'title']);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }
}
