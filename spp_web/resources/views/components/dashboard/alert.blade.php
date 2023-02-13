@if (Session::has('created'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{-- happy --}}
    {{ Session::get('created') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{-- happy --}}
    {{ Session::get('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (Session::has('edited'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    {{-- happy --}}
    {{ Session::get('edited') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (Session::has('updated'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    {{-- happy --}}
    {{ Session::get('updated') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (Session::has('destroyed'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{-- happy --}}
    {{ Session::get('destroyed') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (Session::has('failed'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{-- happy --}}
    {{ Session::get('failed') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif