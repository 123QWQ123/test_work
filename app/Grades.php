<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grades extends Model
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
        'engine_desc' => 'string',
        'wheel_drive' => 'string',
        'price' => 'integer',
        'price_discount' => 'integer',
        'engine' => 'string',
        'transmission' => 'string',
        'body' => 'string',
        'features' => 'array',
        'specifications' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'engine_desc',
        'wheel_drive',
        'price',
        'price_discount',
        'engine',
        'transmission',
        'body',
        'features',
        'specifications',
    ];

    /**
     * Get colors relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function colors()
    {
        return $this->hasMany(Colors::class, 'grade_id');
    }
}
