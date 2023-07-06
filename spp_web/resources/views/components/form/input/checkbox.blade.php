<div>
    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" class="form-check-input " id="{{ $name }}" name="{{ $name }}" value="{{ $value }}"
                @if($hidden) hidden @endif>
            <label class="form-check-label" for="{{ $name }}">{{ $title }}</label>
        </div>
    </div>
    @error($name)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>