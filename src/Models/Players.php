<?php

namespace Azuriom\Plugin\BlockClicker\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

class Players extends Model {

    use HasTablePrefix;
    use HasUser;

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
    protected $fillable = ['id', 'user_id', 'block_id', 'amount'];
    
    /**
     * The user key associated with this model.
     *
     * @var string
     */
    protected $userKey = 'user_id';

    /**
     * Get the user who created this ticket.
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function block() {
        return $this->belongsTo(Blocks::class, 'block_id');
    }
}