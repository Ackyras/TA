<div class="form-group{{ $inLine ? ' row' : '' }}">
    <label for="{{ $name }}" class="{{ $inLine ? 'col-sm-2 col-form-label' : '' }}">{{ $title }}</label>
    <div class="{{ $inLine ? 'col-sm-10' : '' }}">
        <select class="form-control select2bs4" id="{{ $id }}" name="{{ $name }}"
            {{ $disabled ? 'disabled' : '' }}>
            @foreach ($options as $option)
                <option value="{{ $option->id }}"
                    @if ($selected) @if ($selected == $option->id) selected @endif @endif>{{ $option->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
