@extends('admin.layouts.admin')

@section('title', trans('blockclicker::admin.title'))

@section('content')
    <div class="row" id="blockclicker">
        <div class="card shadow mb-4 col-12">
            <div class="card-header">
                <h3>{{ trans('blockclicker::admin.index.summary') }}</h3>
            </div>
            <div class="card-body pt-0 pb-0">
                <div>
                    <p>
                        {{ trans('blockclicker::admin.blocks.count', ['count' => count($blocks)]) }}
                        <a href="{{ route('blockclicker.admin.blocks.index') }}" class="btn btn-info">Voir</a>
                        <a href="{{ route('blockclicker.admin.blocks.create') }}" class="btn btn-success">
                            <i class="bi bi-save"></i> {{ trans('messages.actions.add') }}
                        </a>
                    </p>
                </div>
                <div>
                    <p>
                        {{ trans('blockclicker::admin.players.count', ['count' => count($players)]) }}
                        <a href="{{ route('blockclicker.admin.players.index') }}" class="btn btn-info">Voir</a>
                        <a href="{{ route('blockclicker.admin.players.create') }}" class="btn btn-success">
                            <i class="bi bi-save"></i> {{ trans('messages.actions.add') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
