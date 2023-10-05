<?php

namespace Azuriom\Plugin\BlockClicker\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

class Blocks extends Model {

    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     *
     * @var string
     */
    protected $prefix = 'blockclicker_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'minecraft_id', 'image', 'required_click', 'luck', 'size'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'required_click' => 'integer',
        'luck' => 'integer',
        'size' => 'integer'
    ];
}