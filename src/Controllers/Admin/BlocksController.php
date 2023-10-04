<?php

namespace Azuriom\Plugin\BlockClicker\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\BlockClicker\Models\Blocks;
use Azuriom\Plugin\BlockClicker\Requests\BlocksRequest;

class BlocksController extends Controller {

    public function index() {
        $blocks = Blocks::all();
        return view('blockclicker::admin.blocks.index', compact('blocks'));
    }

    public function create() {
        return view('blockclicker::admin.blocks.create');
    }
    
    public function store(BlocksRequest $blockRequest) {
        Blocks::create($blockRequest->validated());

        return to_route('blockclicker.admin.index')
            ->with('success', trans('blockclicker::admin.block.created'));
    }

    public function edit(Blocks $block) {
        return view('blockclicker::admin.blocks.edit', compact('block'));
    }

    public function update(BlocksRequest $request, Blocks $block) {
        $block->update($request->validated());
        return redirect()->route('blockclicker.admin.index')
            ->with('success', trans('blockclicker::admin.blocks.updated'));
    }

    public function destroy(Blocks $block)
    {
        $block->delete();

        return redirect()->route('blockclicker.admin.index')
            ->with('success', trans('blockclicker::admin.blocks.deleted'));
    }
}
