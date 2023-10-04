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
        <div class="col-md-12">
            <div class="card shadow mb-4">
            <div class="card-header">
                <h3>{{ trans('blockclicker::admin.settings.edit') }}</h3>
            </div>
                <div class="card-body">
                    <form action="{{ route('blockclicker.admin.setting.update', null) }}" name="setting-form" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="serverIdInput">{{ trans('blockclicker::admin.server_id') }}</label>
                            <select name="server_id" id="serverIdInput" class="form-control">
                                @foreach($servers ?? [] as $srv)
                                    <option value="{{ $srv->id }}" @if((setting("blockclicker.server_id") ?? 0) == $srv->id) selected @endif>
                                        {{ $srv->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('server_id')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bagSizeInput">{{ trans('blockclicker::admin.bag_size') }}</label>
                            <input type="text" class="form-control @error('bag_size') is-invalid @enderror" id="bagSizeInput"
                                name="bag_size" value="{{ setting('bag_size') ?? 15 }}" required>

                            @error('bag_size')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="timeCooldownInput">{{ trans('blockclicker::admin.time_cooldown') }}</label>
                            <input type="text" class="form-control @error('time_cooldown') is-invalid @enderror" id="timeCooldownInput"
                                name="time_cooldown" value="{{ setting('time_cooldown') ?? 100 }}" required>

                            @error('time_cooldown')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
