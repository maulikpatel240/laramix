<?php

namespace App\Models\Admin;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Festival extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'festival';

    protected $appends = ['isNewRecord', 'photo_url'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'date',
        'description',
        'photo',
        'is_active',
        'is_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active_at' => 'datetime',
    ];

    // public function photo_url(): Attribute
    // {
    //     return new Attribute(

    //     )
    // }
    public function getIsNewRecordAttribute()
    {
        return $this->attributes['isNewRecord'] = ($this->created_at != $this->updated_at) ? false : true;
    }

    public function getPhotoUrlAttribute()
    {
        $photo_url = asset('storage/festival');
        return $this->attributes['photo_url'] = $this->photo ? $photo_url . '/' . $this->photo : "";
    }
}
