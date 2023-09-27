<?php

namespace Azuriom\Plugin\BlockClicker\Controllers;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIController extends Controller {

    public function click(Request $request) {
        // vérifier le click
        return json_encode([
            "clicked"
        ]);
    }

    public function getRandom(Request $request) {
        $blocks = json_decode(file_get_contents(plugin_asset("blockclicker", "blocks.json")), true);
        $choosedBlock = $blocks[array_rand($blocks)];
        // maintenant faut stocker l'info quelque part
        return json_encode($choosedBlock);
    }
}
