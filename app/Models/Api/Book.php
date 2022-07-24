<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Book extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book';
    protected $appends = ['isCreateChapter', 'isTotalChapter', 'storage_url'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'typeofcategory_id',
        'user_id',
        'title',
        'edition',
        'book_pdf',
        'price_type',
        'price',
        'website',
        'language',
        'publisher_type',
        'publishing_date',
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
        'book_pdf' => 'array',
        'is_active_at' => 'datetime',
    ];
    public function getStorageUrlAttribute()
    {
        return $this->attributes['storage_url'] = asset('storage');
    }
    public function getIsCreateChapterAttribute()
    {

        $checkauthor = Author::where(['book_id' => $this->id, 'user_id' => auth()->user()->id])->first();
        return $this->attributes['isCreateChapter'] = $checkauthor ? 1 : 0;
    }

    public function getIsTotalChapterAttribute()
    {

        $check = BookChapter::where(['book_id' => $this->id])->count();
        return $this->attributes['isTotalIndex'] = $check;
    }

    public function typeofcategory()
    {
        $witharray = [
            'category:id,name,parent'
        ];
        return $this->hasOne(Typeofcategory::class, 'id', 'typeofcategory_id')->select(['id', 'category_id', 'type'])->with($witharray)->where('type', 'Book');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select(['id', 'first_name', 'middle_name', 'last_name', 'phone_number']);
    }
}
