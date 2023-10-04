<?php

namespace Azuriom\Plugin\BlockClicker\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Server;
use Azuriom\Models\Setting;
use Azuriom\Plugin\BlockClicker\Models\Blocks;
use Azuriom\Plugin\BlockClicker\Models\Players;
use Illuminate\Http\Request;

class SettingController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $blocks = Blocks::all();
        $players = Players::all();
        $servers = Server::where("type", "mc-azlink")->get();
        return view('blockclicker::admin.index', compact('blocks', 'players', 'servers'));
    }

    public function save(Request $request) {
        $this->validate($request, [
            'server_id' => ['nullable', 'exists:servers,id'],
            'bag_size' => ['required', 'integer'],
            'time_cooldown' => ['required', 'integer']
        ]);
        Setting::updateSettings([
            'blockclicker.server_id' => $request->input('server_id'),
            'blockclicker.bag_size' => $request->input('bag_size'),
            'blockclicker.time_cooldown' => $request->input('time_cooldown')
        ]);
        return redirect()->route('blockclicker.admin.index')->with('success', trans('blockclicker::admin.settings.updated'));
    }
}
