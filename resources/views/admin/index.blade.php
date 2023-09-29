@extends('admin.layouts.admin')

@section('title', trans('blockclicker::admin.title'))

@section('content')
    <div class="row" id="blockclicker">
        <div class="card shadow mb-4 col-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-6 text-start">
                        <h3>{{ trans('blockclicker::admin.blocks.list') }}</h3>
                    </div>
                    <div class="col-6 text-end">
                        <a href="{{ route('blockclicker.admin.blocks.create') }}" class="btn btn-success">
                            <i class="bi bi-save"></i> {{ trans('messages.actions.add') }}
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('messages.fields.name') }}</th>
                            <th scope="col">{{ trans('messages.fields.action') }}</th>
                        </tr>
                        </thead>
                        <tbody class="sortable" id="games">
                            @forelse($blocks ?? [] as $block)
                                <tr class="sortable-dropdown tag-parent" data-block-id="{{ $block->id }}">
                                    <th scope="row">
                                        {{$block->id}}
                                    </th>
                                    <td>
                                        {{$block->name}}
                                    </td>
                                    <td>
                                        <a href="{{ route('blockclicker.admin.blocks.show', $block) }}" class="mx-1"
                                            title="{{ trans('messages.actions.show') }}" data-toggle="tooltip"><i
                                                class="bi bi-eye-fill"></i></a>
                                        <a href="{{ route('blockclicker.admin.blocks.edit', $block) }}" class="mx-1"
                                            title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i
                                                class="bi bi-pen-fill"></i></a>
                                        <a href="{{ route('blockclicker.admin.blocks.destroy', $block) }}" class="mx-1"
                                            title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip"
                                            data-confirm="delete"><i class="bi bi-trash-fill"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Vous n'avez pas de block</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4 col-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-6 text-start">
                        <h3>{{ trans('blockclicker::admin.players.list') }}</h3>
                    </div>
                    <div class="col-6 text-end">
                        <a href="{{ route('blockclicker.admin.players.store') }}" class="btn btn-success">
                            <i class="bi bi-save"></i> {{ trans('messages.actions.add') }}
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('messages.fields.name') }}</th>
                            <th scope="col">{{ trans('messages.fields.action') }}</th>
                        </tr>
                        </thead>
                        <tbody class="sortable" id="games">
                            @forelse($players ?? [] as $player)
                                <tr class="sortable-dropdown tag-parent" data-block-id="{{ $player->id }}">
                                    <th scope="row">
                                        {{$player->id}}
                                    </th>
                                    <td>
                                        {{$player->user_id}}
                                    </td>
                                    <td>
                                        <a href="{{ route('blockclicker.admin.players.show', $player) }}" class="mx-1"
                                            title="{{ trans('messages.actions.show') }}" data-toggle="tooltip"><i
                                                class="bi bi-eye-fill"></i></a>
                                        <a href="{{ route('blockclicker.admin.players.edit', $player) }}" class="mx-1"
                                            title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i
                                                class="bi bi-pen-fill"></i></a>
                                        <a href="{{ route('blockclicker.admin.players.destroy', $player) }}" class="mx-1"
                                            title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip"
                                            data-confirm="delete"><i class="bi bi-trash-fill"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Aucun joueur n'a joué</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
