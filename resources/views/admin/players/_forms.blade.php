@csrf
<div class="card-body">
    <div class="mb-3">
        <label class="form-label" for="userInput">{{ trans('messages.fields.name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="userInput"
               name="user_id" value="{{ old('user_id', $player->user_id ?? '') }}" required>

        @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="blockInput">{{ trans('blockclicker::admin.block_id') }}</label>
        <select name="block_id" id="blockInput" class="form-control">
            @foreach($blocks as $block)
                <option value="{{ $block->id }}" @if(isset($player->block_id) && $player->block_id == $block->id) selected @endif>
                    {{ $block->name }}
                </option>
            @endforeach
        </select>
        
        @error('block_id')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="amountInput">{{ trans('messages.fields.amount') }}</label>
        <input type="text" class="form-control @error('description') is-invalid @enderror" id="amountInput"
               name="amount" value="{{ old('amount', $player->amount ?? '') }}">

        @error('amount')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>
