@extends('layouts.app')

@section('title', trans('blockclicker::public.title'))

@push('styles')
    <link href="{{ plugin_asset('blockclicker', 'style.css') }} " rel="stylesheet">
@endpush

@section('content')
    <div class="row" id="blockclicker">
        <div class="alert alert-success alert-dismissible d-none" id="blockclicker-alert" role="alert">
            <i class="bi bi-check-circle"></i>
            <span id="blockclicker-message"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="image-container">
            <img style="display: none;" id="block-img" onclick="handleClick()">
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
                }, 2000);
                nextBlock();
            }
        }

        nextBlock();
    </script>
@endpush