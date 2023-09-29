<?php

namespace Azuriom\Plugin\BlockClicker\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\BlockClicker\Models\Blocks;
use Illuminate\Http\Request;

class APIController extends Controller {

    public function click(Request $request) {
        // vérifier le click
        return json_encode([
            "clicked",
            $request->session()->get("some")
        ]);
    }

    public function getRandom(Request $request) {
        $blocks = [];
        foreach(Blocks::all() as $block) {
            for($i = 0; $i < $block->luck; $i++) {
                array_push($blocks, $block);
            }
        }
        $choosedBlock = $blocks[array_rand($blocks)];
        $request->session()->put("some", $choosedBlock);
        return json_encode($choosedBlock);
    }
}
