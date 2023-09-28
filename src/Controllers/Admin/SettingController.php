<?php

namespace Azuriom\Plugin\BlockClicker\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\BlockClicker\Models\Blocks;

class SettingController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $blocks = Blocks::all();
        return view('blockclicker::admin.index', compact('blocks'));
    }
}
