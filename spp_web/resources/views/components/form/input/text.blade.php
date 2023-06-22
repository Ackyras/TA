<div>
    <div class="form-group">
        <label for="{{ $name }}">{{ $title }}</label>
        <input type="text" class="form-control" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}" @if($hidden)
            hidden @endif>
    </div>
    @error($name)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>