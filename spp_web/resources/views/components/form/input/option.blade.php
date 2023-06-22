<div>
    <div class="form-group">
        <label for="{{ $name }}">{{ $title }}</label>
        <select class="form-control select2bs4" id="select2" name="{{ $name }}">
            @foreach ($options as $option)
            <option value="{{ $option->id }}" @if ($selected==$option->id) selected @endif>{{ $option->name }}</option>
            @endforeach
        </select>
    </div>
</div>