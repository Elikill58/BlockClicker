@extends('layouts.app')

@section('title', trans('blockclicker::public.title'))

@push('styles')
    <link href="{{ plugin_asset('blockclicker', 'style.css') }} " rel="stylesheet">
@endpush

@section('content')
    <div class="alert alert-success alert-dismissible d-none" id="blockclicker-alert" role="alert">
        <i class="bi bi-check-circle"></i>
        <span id="blockclicker-message"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="row" id="blockclicker">
        <div class="col-12 col-sm-6">
            <div class="card mb-2">
                <div class="card-header">
                    <h3>{{ trans('blockclicker::public.bag.index') }}</h3>
                </div>
                <div class="card-body">
                    @if($myPlayers == null)
                    <div>
                        {{ trans('blockclicker::public.need_auth') }}
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">{{ trans('blockclicker::admin.block') }}</th>
                                <th scope="col">{{ trans('blockclicker::admin.amount') }}</th>
                            </tr>
                            </thead>
                            <tbody class="sortable" id="myPlayers">
                                @foreach($myPlayers ?? [] as $player)
                                    <tr class="sortable-dropdown tag-parent">
                                        <th>
                                            {{$player->block->name}}
                                        </th>
                                        <td>
                                            {{$player->amount}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>{{ trans('blockclicker::public.rank.index') }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">{{ trans('blockclicker::public.rank.index') }}</th>
                                <th scope="col">{{ trans('messages.fields.name') }}</th>
                                <th scope="col">{{ trans('blockclicker::admin.amount') }}</th>
                            </tr>
                            </thead>
                            <tbody class="sortable" id="players">
                                @php($i = 1)
                                @forelse($players ?? [] as $player)
                                    <tr class="sortable-dropdown tag-parent">
                                        <th scope="row">
                                            {{$i++}}
                                        </th>
                                        <th>
                                            {{$player->user}}
                                        </th>
                                        <td>
                                            {{$player->amount}}
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
        <div class="col-12 col-sm-6">
            @if($myPlayers == null)
            <div>
                {{ trans('blockclicker::public.need_auth') }}
            </div>
            @else
            <div class="image-container" style="max-width: -webkit-fill-available;">
                <img style="display: none; max-width: -webkit-fill-available; height: auto;" id="block-img" onclick="handleClick()">
            </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

        async function nextBlock() {
            var rawResult = await fetch("{{ route('blockclicker.random') }}");
            var block = await rawResult.json();
            var img = document.getElementById("block-img");
            img.style.display = null;
            img.src = block.image;
            update();
        }

        var canClick = true;

        async function handleClick() {
            if(!canClick)
                return;
            canClick = false;
            document.getElementById("block-img").classList.add("shake");
            
            setTimeout(() => {
                document.getElementById("block-img").classList.remove("shake");
                canClick = true;
            }, 500);
            const result = await (await fetch("{{ route('blockclicker.click') }}")).json();
            if(result.result == "updated" || result.result == "created") {
                document.getElementById("blockclicker-alert").classList.remove("d-none");
                document.getElementById("blockclicker-message").textContent = (result.result == "updated" ? "{{ trans('blockclicker::public.block.updated') }}" : "{{ trans('blockclicker::public.block.created') }}");
                setTimeout(() => {
                    document.getElementById("blockclicker-alert").classList.add("d-none");
                }, 3000);
                nextBlock();
            }
        }

        async function update() {
            var body = document.getElementById("myPlayers");
            const result = await (await fetch("{{ route('blockclicker.mined') }}")).json();
            body.innerHTML = "";
            for(var line of result) {
                body.innerHTML += `
                    <tr class="sortable-dropdown tag-parent">
                        <th>
                            ` + line.block_name + `
                        </th>
                        <td>
                            ` + line.amount + `
                        </td>
                    </tr>`;
            }
        }

        nextBlock();
    </script>
@endpush