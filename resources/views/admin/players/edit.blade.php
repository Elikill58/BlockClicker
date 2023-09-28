@extends('admin.layouts.admin')

@section('title', trans('blockclicker::admin.players.edit.title') .' : '.$player->name)

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('blockclicker.admin.players.update', $player)}}" method="POST" id="playerForm">
                @include('blockclicker::admin.players._form')
                @method('PUT')

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>

                <a href="{{ route('blockclicker.admin.players.destroy', $player) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="bi bi-trash-fill"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection