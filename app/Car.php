<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'title' => 'string',
        'sprite' => 'string',
        'image' => 'string',
        'link' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'sprite',
        'image',
        'link',
    ];


    /**
     * Get grade relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function grade()
    {
        return $this->hasOne(Grades::class, 'car_id');
    }
}
