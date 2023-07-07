<div>
    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" class="form-check-input " id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
                @if($hidden) hidden @endif @if($checked) checked @endif>
            <label class="form-check-label" for="{{ $id }}">{{ $title }}</label>
        </div>
    </div>
    @error($name)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>