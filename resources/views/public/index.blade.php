@extends('layouts.app')

@section('title', trans('blockclicker::public.title'))

@push('styles')
    <link href="{{ plugin_asset('blockclicker', 'style.css') }} " rel="stylesheet">
@endpush

@section('content')
    <!--div class="alert alert-success alert-dismissible d-none" id="blockclicker-alert" role="alert">
        <i class="bi bi-check-circle"></i>
        <span id="blockclicker-message"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div-->
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
                            (<span id="bagUsed">{{ $myPlayers->bagSizeUsed() }}</span>/<span id="bagSize">{{ $myPlayers->bagSize() }}</span>)
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
                                <div class="col-2 text-end" style="z-index: 100;">
                                    <img src="{{$mined->block->image}}" style="width: -webkit-fill-available;" id="mined_{{ $mined->id }}" data-block-id="{{ $mined->block->id }}" data-amount="{{ $mined->amount }}">
                                    <span class="badge-blockclicker">{{ $mined->amount }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @endif
                    <div class="d-flex my-2" style="align-items: center;">
                        <div style="width: 50px; min-height: 20px; padding: 10px; border: 1px solid #aaaaaa;" id="trash-img" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div class="d-none" id="trash-manager"></div>
                        <a href="#blockclicker" onclick="trash()"><i class="bi bi-trash-fill mx-1"></i></a>
                    </div>
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
        <div class="col-12 col-sm-6" id="blockclicker-miner">
            @if($myPlayers == null)
            <div>
                {{ trans('blockclicker::public.need_auth') }}
            </div>
            @elseif($myPlayers->bagSizeUsed() >= $myPlayers->bagSize())
                {{ trans('blockclicker::public.bag.full') }}
            @else
                <progress value="0" id="image-progress" style="width: 100%;"></progress>
                <div class="image-container" style="max-width: -webkit-fill-available; height: auto;">
                    <img style="display: none; max-width: -webkit-fill-available; height: auto;" id="block-img" onclick="handleClick()">
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        const blockImgElement = document.getElementById("block-img");
        const progressElement = document.getElementById("image-progress");
        const baseUsedElement = document.getElementById("bagUsed");

        function isMineLimited() {
            return parseInt(baseUsedElement.innerHTML) >= parseInt(document.getElementById("bagSize").innerHTML);
        }

        async function updateProgressBar(actual, required) {
            progressElement.value = actual;
            progressElement.max = required;
        }

        async function manageTooManyBlock() {
            document.getElementById("blockclicker-miner").innerHTML = `{{ trans('blockclicker::public.bag.full') }}`;
        }

        async function nextBlock() {
            const block = await (await fetch("{{ route('blockclicker.random') }}")).json()
            if(Object.keys(block).length === 0) {
                manageTooManyBlock();
            } else {
                blockImgElement.style.display = null;
                blockImgElement.src = block.image;
                updateProgressBar(block.actual, block.required);
            }
            updateMinedBlocks();
        }

        var canClick = true;

        async function handleClick() {
            if(!canClick || isMineLimited())
                return;
            canClick = false;
            blockImgElement.classList.add("shake");
            
            setTimeout(() => {
                blockImgElement.classList.remove("shake");
                canClick = true;
            }, parseInt('{{ setting("blockclicker.time_cooldown") }}'));
            
            const result = (await axios.post("{{ route('blockclicker.click') }}")).data;
            if(result.result == "updated" || result.result == "created") {
                /*document.getElementById("blockclicker-alert").classList.remove("d-none");
                document.getElementById("blockclicker-message").textContent = (result.result == "updated" ? "{{ trans('blockclicker::public.block.updated') }}" : "{{ trans('blockclicker::public.block.created') }}");
                setTimeout(() => {
                    document.getElementById("blockclicker-alert").classList.add("d-none");
                }, 3000);*/
                nextBlock();
            } else if(result.result == "nothing") {
                nextBlock();
            } else if(result.result == "too_many") {
                manageTooManyBlock();
                updateMinedBlocks();
            } else if(result.result == "not_finished") {
                updateProgressBar(result.actual, result.required);
            }
        }

        async function updateMinedBlocks() {
            var body = document.getElementById("myPlayers");
            const result = await (await fetch("{{ route('blockclicker.mined') }}")).json();
            body.innerHTML = "";
            var totalAmount = 0;
            var size = 0;
            for(var line of result) {
                if(line.amount == 0)
                    continue;
                body.innerHTML += `
                    <div class="col-2 text-end">
                        <img src="` + line.block_image + `" style="width: -webkit-fill-available;" id="mined_` + line.id + `"
                            data-block-id="` + line.block_id + `" data-amount="` + line.amount + `">
                        <span class="badge-blockclicker">` + line.amount + `</span>
                    </div>`;
                totalAmount += line.amount;
                size += line.block_size * line.amount;
            }
            const maxBagSize = parseInt(document.getElementById("bagSize").innerHTML);
            document.getElementById("sendButton").disabled = totalAmount == 0;
            baseUsedElement.textContent = size > maxBagSize ? maxBagSize : size;
            document.getElementById("trash-img").innerHTML = "";
            document.getElementById("trash-manager").innerHTML = "";
            if(size >= maxBagSize)
                manageTooManyBlock();
        }

        async function send() {
            await axios.post("{{ route('blockclicker.send') }}");
            updateMinedBlocks(); // should be empty
        }

        async function trash() {
            var trash = document.getElementById("trash-manager");
            var input = trash.getElementsByTagName("input")[0];
            trash.innerHTML = "";
            trash.classList.add("d-none");
            await axios.post("{{ route('blockclicker.trash') }}", {
                "blockId": input.dataset.blockId,
                "amount": input.value
            });
            location.reload();
        }

        nextBlock();
    </script>

    <script>
    document.addEventListener("dragstart", manageDrag);

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function manageDrag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();
        var div = document.getElementById(ev.dataTransfer.getData("text"));
        var datas = div.dataset;
        var trash = document.getElementById("trash-manager");
        div.parentNode.remove();
        ev.target.appendChild(div);
        trash.classList.remove("d-none");
        trash.innerHTML = `<input type="number" class="form-control" style="max-width: 100px;" value="` + datas.amount + `" min="0" max="` + datas.amount + `" data-block-id="` + datas.blockId + `">`;
    }
    </script>
@endpush