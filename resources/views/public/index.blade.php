@extends('layouts.app')

@section('title', trans('blockclicker::public.title'))

@push('styles')
    <link href="{{ plugin_asset('blockclicker', 'style.css') }} " rel="stylesheet">
@endpush

@section('content')
    <div class="row" id="blockclicker">
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
            img.src = "{{ plugin_asset('blockclicker', 'img/AAAAA') }}/".replace("AAAAA", block.src);
        }

        function handleClick() {
            fetch("{{ route('blockclicker.click') }}");
            document.getElementById("block-img").classList.add("shake");
            
            setTimeout(() => {
                document.getElementById("block-img").classList.remove("shake");
            }, 500);
        }

        nextBlock();
    </script>
@endpush