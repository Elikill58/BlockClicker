<?php

namespace Azuriom\Plugin\BlockClicker\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\BlockClicker\Models\Blocks;
use Azuriom\Plugin\BlockClicker\Models\Players;
use Illuminate\Http\Request;

class APIController extends Controller {

    public function click(Request $request) {
        $actualClicks = $request->session()->get("blockclicker_actual");
        $block = $actualClicks["block"];
        $click = $actualClicks["click"] + 1;
        if($click >= $block->required_click) {
            $request->session()->remove("blockclicker_actual");
            $userId = auth()->user()->getAuthIdentifier();
            $players = Players::where("user_id", $userId)->where("block_id", $block->id)->get();
            if(count($players) == 0) { // first time break this block
                Players::create([
                    "user_id" => $userId,
                    "block_id" => $block->id,
                    "amount" => 1
                ]);
                return json_encode([
                    "result" => "created"
                ]);
            } else { // already get it
                $player = $players[0];
                $player->amount++;
                $player->update();
                return json_encode([
                    "result" => "updated"
                ]);
            }
        } else {
            $this->setSessionForBlock($request, $block, $click);
        }
        // vérifier le click
        return json_encode([
            "result" => "not_finished"
        ]);
    }

    public function getRandom(Request $request) {
        $actualClicks = $request->session()->get("blockclicker_actual");
        if($actualClicks != null)
            $choosedBlock = $actualClicks["block"];
        else {
            $blocks = [];
            foreach(Blocks::all() as $block) {
                for($i = 0; $i < $block->luck; $i++) {
                    array_push($blocks, $block);
                }
            }
            $choosedBlock = $blocks[array_rand($blocks)];
            $this->setSessionForBlock($request, $choosedBlock, 0);
        }
        return json_encode([
            "id" => $choosedBlock->id,
            "name" => $choosedBlock->name,
            "image" => $choosedBlock->image
        ]);
    }

    private function setSessionForBlock(Request $request, Blocks $block, int $click) {
        $request->session()->put("blockclicker_actual", [
            "block" => $block,
            "click" => $click,
            "last_interact" => floor(microtime(true) * 1000)
        ]);
    }

    public function getAllMinedBlocks() {
        $auth = auth();
        if($auth != null && $auth->user() != null) {
            $userId = $auth->user()->getAuthIdentifier();
            $myPlayers = Players::where("user_id", $userId)->get();
            foreach($myPlayers as $p) {
                $p->block_name = $p->block->name;
                unset($p->block);
            }
        } else {
            $myPlayers = null;
        }
        return json_encode($myPlayers);
    }
}
