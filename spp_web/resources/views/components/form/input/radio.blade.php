<div class="form-group">
    <div class="form-radio">
        <input type="radio" class="form-radio-input" id="{{ $id }}" name="{{ $name }}"
            value="{{ $value }}" @if ($hidden) hidden @endif
            @if ($checked) checked @endif>
        <label class="form-check-label" for="{{ $id }}">{{ $title }}</label>
    </div>
    @error($name)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
