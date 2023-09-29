@extends('admin.layouts.admin')

@section('title', trans('blockclicker::admin.blocks.create.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('blockclicker.admin.blocks.store')}}" method="POST" id="blockForm">
                @include('blockclicker::admin.blocks._form')
                @method('POST')

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection