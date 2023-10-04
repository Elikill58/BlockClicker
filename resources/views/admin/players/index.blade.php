@extends('admin.layouts.admin')

@section('title', trans('blockclicker::admin.title'))

@section('content')
    <div class="row" id="blockclicker">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-6 text-start">
                        <h3>{{ trans('blockclicker::admin.players.list') }}</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('messages.fields.name') }}</th>
                            <th scope="col">{{ trans('blockclicker::admin.amount_monthly') }}</th>
                            <th scope="col">{{ trans('blockclicker::admin.bag_size') }}</th>
                            <th scope="col">{{ trans('messages.fields.action') }}</th>
                        </tr>
                        </thead>
                        <tbody class="sortable" id="games">
                            @forelse($players ?? [] as $player)
                                <tr class="sortable-dropdown tag-parent" data-player-id="{{ $player->id }}">
                                    <th scope="row">
                                        {{$player->id}}
                                    </th>
                                    <td>
                                        {{$player->user->name}}
                                    </td>
                                    <td>
                                        {{$player->amount_monthly}}
                                    </td>
                                    <td>
                                        @if($player->bag_size == 0)
                                            {{ trans('blockclicker::admin.default_bag_size') }}
                                        @else
                                            {{$player->bag_size}}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('blockclicker.admin.players.edit', $player) }}" class="mx-1"
                                            title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <a href="{{ route('blockclicker.admin.players.destroy', $player) }}" class="mx-1"
                                            title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip"
                                            data-confirm="delete"><i class="bi bi-trash-fill"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Aucun joueur n'a joué</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
