<?php

namespace Azuriom\Plugin\BlockClicker\Controllers;

use Azuriom\Http\Controllers\Controller;
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
            $myPlayers = Players::where("user_id", $userId)->get();
        } else {
            $myPlayers = null;
        }
        return view('blockclicker::public.index', compact('players', 'myPlayers'));
    }
}
