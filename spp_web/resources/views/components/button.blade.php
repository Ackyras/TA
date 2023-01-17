<div>
    @if ($type == 'submit')
    <button class="{{ $class }}" type="submit">{{ $text }}</button>
    @elseif($type == 'redirect')
    <a href="{{ $route }}" role="button" class="{{ $class }}">{{ $text }}</a>
    @elseif ($type == 'delete')
    <form action="{{ $route }}" method="post">
        @method('DELETE')
        @csrf
        <button class="{{ $class }}" type="submit" onclick="confirm('Yakin ingin menghapus data?')">{{ $text }}</button>
    </form>
    @endif
</div>
@push('script')
@endpush
