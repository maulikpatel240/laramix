<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permission';

    protected $appends = ['isNewRecord'];

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'module_id',
        'panel',
        'title',
        'name',
        'controller',
        'action',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // 'is_active_at' => 'datetime',
    ];

    public function getIsNewRecordAttribute()
    {
        //   return $this->attributes['isNewRecord'] = ($this->created_at != $this->updated_at) ? false : true;
    }
}
