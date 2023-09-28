@extends('admin.layouts.admin')

@section('title', trans('blockclicker::admin.blocks.edit.title') .' : '.$block->name)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    @include('blockclicker::admin.blocks._form')
                    <a href="{{ route('blockclicker.admin.blocks.edit', $block) }}" type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> {{ trans('messages.actions.edit') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection