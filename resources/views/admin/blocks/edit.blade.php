@extends('admin.layouts.admin')

@section('title', trans('blockclicker::admin.blocks.edit.title') .' : '.$block->name)

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('blockclicker.admin.blocks.update', $block)}}" method="POST" id="blockForm">
                @include('blockclicker::admin.blocks._form')
                @method('PUT')

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>

                <a href="{{ route('blockclicker.admin.blocks.destroy', $block) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="bi bi-trash-fill"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection