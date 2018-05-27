<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colors extends Model
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
        'rgb' => 'string',
        'code' => 'string',
        'title' => 'string',
        'type' => 'string',
        'price' => 'integer',
        'swatch' => 'string',
        'image' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'rgb',
        'code',
        'title',
        'type',
        'price',
        'swatch',
        'image',
    ];
}
