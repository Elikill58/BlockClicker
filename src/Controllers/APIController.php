<?php

namespace Azuriom\Plugin\BlockClicker\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Server;
use Azuriom\Plugin\BlockClicker\Models\Blocks;
use Azuriom\Plugin\BlockClicker\Models\Mineds;
use Azuriom\Plugin\BlockClicker\Models\Players;
use Illuminate\Http\Request;

class APIController extends Controller {

    public function click(Request $request) {
        $actualClicks = $request->session()->get("blockclicker_actual");
        if($actualClicks == null) {
            return json_encode([
                "result" => "nothing"
            ]);
        }
        $lastInteract = $actualClicks["last_interact"];
        $nowInteract = floor(microtime(true) * 1000);
        if($lastInteract + (setting("blockclicker.time_cooldown") ?? 100) > $nowInteract) {
            return json_encode([
                "result" => "not_finished"
            ]);
        }
        $block = $actualClicks["block"];
        $click = $actualClicks["click"] + 1;
        if($click >= $block->required_click) {
            $request->session()->remove("blockclicker_actual");
            $userId = auth()->user()->getAuthIdentifier();
            $player = Players::where("user_id", $userId)->first();
            if($player == null) { // just create one
                $player = Players::create([
                    "user_id" => $userId,
                    "amount_monthly" => 0,
                    "bag_size" => 0
                ]);
            }
            $mineds = Mineds::where("player_id", $player->id)->where("block_id", $block->id)->get();
            if(count($mineds) == 0) { // first time break this block
                Mineds::create([
                    "player_id" => $player->id,
                    "block_id" => $block->id,
                    "amount" => 1,
                    "amount_reward" => 0
                ]);
                return json_encode([
                    "result" => "created"
                ]);
            } else { // already get it
                $mined = $mineds[0];
                $mined->amount++;
                $mined->update();
                $player->amount_monthly++;
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
        $mineds = [];
        if($auth != null && $auth->user() != null) {
            $userId = $auth->user()->getAuthIdentifier();
            $myPlayers = Players::where("user_id", $userId)->first();
            foreach($myPlayers->mineds() as $mined) {
                array_push($mineds, [
                    "id" => $mined->id,
                    "block_id" => $mined->block->id,
                    "block_name" => $mined->block->name,
                    "block_image" => $mined->block->image,
                    "amount" => $mined->amount,
                    "amount_reward" => $mined->amount_reward
                ]);
            }
        }
        return json_encode($mineds);
    }

    public function sendToServer() {
        $serverId = setting("blockclicker.server_id");
        if($serverId == null || $serverId == "")
            return;
        $auth = auth();
        if($auth == null || $auth->user() == null) 
            return;
        $user = $auth->user();
        $userId = $user->getAuthIdentifier();
        $srv = Server::where("id", $serverId)->first();
        $player = Players::where("user_id", $userId)->first();
        $commands = [];
        foreach($player->mineds() as $mined) {
            if($mined->amount == 0)
                continue;
            array_push($commands, "give " . $user->name . " " . $mined->block->minecraft_id . " " . $mined->amount);
            $mined->amount_reward += $mined->amount;
            $mined->amount = 0;
            $mined->update();
        }
        $srv->bridge()->sendCommands($commands, $user, true);
    }
    
    public function trash(Request $request) {
        $blockId = $request->input("blockId");
        $amount = $request->input("amount");
        if($blockId == null || $amount == null)
            return;
        if($amount < 0)
            return;
        $auth = auth();
        if($auth == null || $auth->user() == null) 
            return;
        $userId = $auth->user()->getAuthIdentifier();
        $player = Players::where("user_id", $userId)->first();
        $mined = Mineds::where("player_id", $player->id)->where("block_id", $blockId)->first();
        if($mined == null)
            return;
        if($mined->amount <= $amount) {
            $mined->amount = 0;
        } else {
            $mined->amount -= $amount;
        }
        $mined->update();
    }
}
