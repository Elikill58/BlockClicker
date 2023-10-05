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
    protected $fillable = ['id', 'user_id', 'amount_monthly', 'bag_size'];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount_monthly' => 'integer',
        'bag_size' => 'integer'
    ];
    
    /**
     * Get the user who created this ticket.
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mineds() {
        return Mineds::where("player_id", $this->id)->get();
    }

    public function bagSize() {
        return intval(setting('blockclicker.bag_size') ?? '10') + $this->bag_size;
    }

    public function bagSizeUsed() {
        $mineds = $this->mineds();
        $i = 0;
        foreach($mineds as $m)
            $i += $m->block->size * $m->amount;
        return $i;
    }

    public static function classement() {
        return Players::orderBy("amount_monthly", "desc")->limit(100)->get();
    }
}