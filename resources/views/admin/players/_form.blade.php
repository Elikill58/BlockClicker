@csrf
<div class="card-body">
    <div class="mb-3">
        <label class="form-label" for="userInput">{{ trans('messages.fields.name') }}</label>
        <p>{{ $player->user->name }}</p>
        <input type="hidden" value="{{ $player->user_id }}" name="user_id">
    </div>
    <div class="mb-3">
        <label class="form-label" for="amountMonthlyInput">{{ trans('blockclicker::admin.amount_monthly') }}</label>
        <input type="number" class="form-control @error('amount_monthly') is-invalid @enderror" id="amountMonthlyInput"
               name="amount_monthly" value="{{ old('amount_monthly', $player->amount_monthly ?? '') }}">
        
        @error('amount_monthly')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="bagSizeInput">{{ trans('blockclicker::admin.bag_size') }}</label>
        <input type="number" class="form-control @error('bag_size') is-invalid @enderror" id="bagSizeInput"
               name="bag_size" value="{{ old('bag_size', $player->bag_size ?? '') }}">

        @error('bag_size')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">{{ trans('blockclicker::admin.block') }}</th>
                    <th scope="col">{{ trans('blockclicker::admin.amount') }}</th>
                    <th scope="col">{{ trans('blockclicker::admin.amount_reward') }}</th>
                    <th scope="col">{{ trans('messages.fields.action') }}</th>
                </tr>
                </thead>
                <tbody class="sortable" id="players">
                    @forelse($player->mineds() ?? [] as $mined)
                        <tr class="sortable-dropdown tag-parent">
                            <th scope="row">
                                {{$mined->block->name}}
                            </th>
                            <th>
                                {{$mined->amount}}
                            </th>
                            <td>
                                {{$mined->amount_reward}}
                            </td>
                            <td>
                                {{$mined->amount_reward}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Aucun joueur n'a joué</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
