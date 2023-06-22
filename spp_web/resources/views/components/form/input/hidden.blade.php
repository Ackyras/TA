<div>
    <div class="form-group">
        <input type="hidden" class="form-control" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}">
    </div>
    @error($name)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>