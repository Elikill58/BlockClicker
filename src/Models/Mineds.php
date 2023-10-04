<?php

namespace Azuriom\Plugin\BlockClicker\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

class Mineds extends Model {

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
    protected $fillable = ['id', 'player_id', 'block_id', 'amount', 'amount_reward'];
        
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'integer',
        'amount_reward' => 'integer'
    ];

    /**
     * Get the user who created this ticket.
     */
    public function player() {
        return $this->belongsTo(User::class, 'player_id');
    }

    public function block() {
        return $this->belongsTo(Blocks::class, 'block_id');
    }
}