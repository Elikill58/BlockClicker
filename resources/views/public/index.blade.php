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
                    <div class="row">
                        <div class="col-6 text-start">
                            <h3>{{ trans('blockclicker::public.bag.index') }}</h3>
                        </div>
                        <div class="col-6 text-end">
                            @if($myPlayers != null)
                            (<span id="bagUsed">{{ $myPlayers->bagSizeUsed() }}</span>/<span id="bagSize">{{ intval(setting('blockclicker.bag_size') ?? '10') + $myPlayers->bag_size }}</span>)
                            @endif
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <button onclick="send()" class="btn btn-success mt-1" disabled id="sendButton">{{ trans('blockclicker::public.send') }}</button>
                    @if($myPlayers == null)
                    <div>
                        {{ trans('blockclicker::public.need_auth') }}
                    </div>
                    @else
                    <div class="d-flex" id="myPlayers">
                        @foreach($myPlayers->mineds() as $mined)
                            @if($mined->amount > 0)
                                <div class="col-2 text-end">
                                    <img src="{{$mined->block->image}}" style="width: -webkit-fill-available;">
                                    <span class="badge badge-blockclicker">{{ $mined->amount }}</span>
                                </div>
                            @endif
                        @endforeach
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
                                <th scope="col">{{ trans('blockclicker::admin.amount_monthly') }}</th>
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
                                            {{$player->user->name}}
                                        </th>
                                        <td>
                                            {{$player->amount_monthly}}
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
            <div class="image-container" style="max-width: -webkit-fill-available; height: auto;">
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
            }, parseInt('{{ setting("blockclicker.time_cooldown") }}'));
            const result = await (await fetch("{{ route('blockclicker.click') }}")).json();
            if(result.result == "updated" || result.result == "created") {
                document.getElementById("blockclicker-alert").classList.remove("d-none");
                document.getElementById("blockclicker-message").textContent = (result.result == "updated" ? "{{ trans('blockclicker::public.block.updated') }}" : "{{ trans('blockclicker::public.block.created') }}");
                setTimeout(() => {
                    document.getElementById("blockclicker-alert").classList.add("d-none");
                }, 3000);
                nextBlock();
            } else if(result.result == "nothing") {
                nextBlock();
            }
        }

        async function update() {
            var body = document.getElementById("myPlayers");
            const result = await (await fetch("{{ route('blockclicker.mined') }}")).json();
            document.getElementById("sendButton").disabled = result.length == 0;
            body.innerHTML = "";
            var totalAmount = 0;
            for(var line of result) {
                if(line.amount == 0)
                    continue;
                body.innerHTML += `
                    <div class="col-2 text-end">
                        <img src="` + line.block_image + `" style="width: -webkit-fill-available;">
                        <span class="badge badge-blockclicker">` + line.amount + `</span>
                    </div>`;
                totalAmount += line.amount;
            }
            document.getElementById("bagUsed").textContent = totalAmount;
        }

        async function send() {
            await fetch("{{ route('blockclicker.send') }}");
            update(); // should be empty
        }

        nextBlock();
    </script>
@endpush