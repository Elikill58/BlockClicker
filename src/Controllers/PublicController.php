<?php

namespace Azuriom\Plugin\BlockClicker\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\BlockClicker\Models\Mineds;
use Azuriom\Plugin\BlockClicker\Models\Players;

class PublicController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $players = Players::classement();
        $auth = auth();
        if($auth != null && $auth->user() != null) {
            $userId = $auth->user()->getAuthIdentifier();
            $myPlayers = Players::where("user_id", $userId)->first();
            if($myPlayers == null) { // just create one
                $myPlayers = Players::create([
                    "user_id" => $userId,
                    "amount_monthly" => 0,
                    "bag_size" => 0
                ]);
            }
            $mineds = Mineds::where("player_id", $myPlayers->id)->get();
        } else {
            $myPlayers = null;
            $mineds = null;
        }
        return view('blockclicker::public.index', compact('players', 'myPlayers', 'mineds'));
    }
}
