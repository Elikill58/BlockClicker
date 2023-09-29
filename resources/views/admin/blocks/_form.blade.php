@csrf
<div class="card-body">
    <div class="mb-3">
        <label class="form-label" for="nameInput">{{ trans('messages.fields.name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput"
               name="name" value="{{ old('name', $block->name ?? '') }}" required>

        @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="requiredClickInput">{{ trans('blockclicker::admin.required_click') }}</label>
        <input type="text" class="form-control @error('description') is-invalid @enderror" id="requiredClickInput"
               name="required_click" value="{{ old('required_click', $block->required_click ?? '') }}">

        @error('required_click')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="luckInput">{{ trans('blockclicker::admin.luck') }}</label>
        <input type="text" class="form-control @error('description') is-invalid @enderror" id="luckInput"
               name="luck" value="{{ old('luck', $block->luck ?? '') }}">

        @error('luck')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="imageInput">{{ trans('messages.fields.image') }}</label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" id="imageInput"
                name="imageFake" onchange="update64File()">
        <input type="hidden" name="image" id="image">
        @error('image')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <img src="{{ old('image', $block->image ?? '') }}" class="d-none" id="image-preview" alt="Preview">
    </div>
</div>

@push('footer-scripts')
    <script>
        const toBase64 = file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = reject;
        });
        
        async function update64File() {
            var base64 = await toBase64(document.getElementById('imageInput').files[0]);
            document.getElementById("image").value = base64;
            document.getElementById("image-preview").src = base64;
            document.getElementById("image-preview").classList.remove("d-none");
        }
    </script>
@endpush