@extends('admin.layouts.admin')

@section('title', trans('blockclicker::admin.players.edit.title') .' : '.$player->name)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    @include('blockclicker::admin.players._form')
                    <a href="{{ route('blockclicker.admin.players.edit', $player) }}" type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> {{ trans('messages.actions.edit') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection