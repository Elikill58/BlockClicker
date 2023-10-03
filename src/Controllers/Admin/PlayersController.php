<?php

namespace Azuriom\Plugin\BlockClicker\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\BlockClicker\Models\Blocks;
use Azuriom\Plugin\BlockClicker\Models\Players;
use Azuriom\Plugin\BlockClicker\Requests\PlayersRequest;

class PlayersController extends Controller {

    public function index() {
        $players = Players::all();
        return view('blockclicker::admin.players.index', compact('players'));
    }

    public function show(Players $player)
    {
        return view('blockclicker::admin.players.show', compact('player'));
    }
    
    public function store(PlayersRequest $playerRequest) {
        Players::create($playerRequest->validated());

        return redirect()->route('blockclicker.admin.index')
            ->with('success', trans('blockclicker::admin.block.created'));
    }

    public function edit(Players $player)
    {
        $blocks = Blocks::all();
        return view('blockclicker::admin.players.edit', compact('player', 'blocks'));
    }

    public function update(PlayersRequest $request, Players $player)
    {
        $player->update($request->validated());
        return redirect()->route('blockclicker.admin.index')
            ->with('success', trans('blockclicker::admin.players.updated'));
    }

    public function destroy(Players $player)
    {
        $player->delete();

        return redirect()->route('blockclicker.admin.index')
            ->with('success', trans('blockclicker::admin.players.deleted'));
    }
}
