<div>
    @if ($inLine)
        <div class="form-group row">
            <label for="{{ $name }}" class="col-sm-2 col-form-label">{{ $title }}</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="{{ $name }}" name="{{ $name }}"
                    value="{{ $value }}" @if ($hidden) hidden @endif
                    {{ $disabled ? 'disabled' : '' }}>
            </div>
        </div>
    @else
        <div class="form-group">
            <label for="{{ $name }}">{{ $title }}</label>
            <input type="number" class="form-control" id="{{ $name }}" name="{{ $name }}"
                value="{{ $value }}" @if ($hidden) hidden @endif
                {{ $disabled ? 'disabled' : '' }}>
        </div>
    @endif
    @error($name)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
