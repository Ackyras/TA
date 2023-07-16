@extends('layouts.app')

@section('title', 'List Kelompok Tani')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List Kelompok Tani</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.farmer.index') }}" method="GET" class="mb-3">
                <div class="card border-0">
                    <div class="card-header p-2" data-toggle="collapse" data-target="#filterCard" aria-expanded="false"
                        aria-controls="filterCard">
                        <a class="card-title mb-0 font-weight-bold">Filter</a>
                        <button class="btn btn-link btn-sm float-right p-0" type="button" data-toggle="collapse"
                            data-target="#filterCard" aria-expanded="false" aria-controls="filterCard">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div id="filterCard" class="collapse">
                        <div class="card-body p-2">
                            <x-form.input.text name="filter[name]" title="Name" :value="request()->input('filter.name')" :in-line="true" />
                            <x-form.input.text name="filter[pic]" title="PIC" :value="request()->input('filter.pic')" :in-line="true" />
                        </div>
                        <div class="card-footer d-flex justify-content-end p-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </div>
            </form>

            <table id="FarmerTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>PIC</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($farmers as $farmer)
                        <tr>
                            <td>{{ $farmer->name }}</td>
                            <td>{{ $farmer->address }}, {{ $farmer->village->name }}, {{ $farmer->village->district->name }}
                            </td>
                            <td>{{ $farmer->pic }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between mt-4">
                <div>
                    Showing {{ $farmers->firstItem() }} to {{ $farmers->lastItem() }} of {{ $farmers->total() }} entries
                </div>
                @if ($farmers->lastPage() > 1)
                    <div class="btn-group pagination">
                        @if ($farmers->currentPage() > 1)
                            <a class="btn btn-default" href="{{ $farmers->url($farmers->currentPage() - 1) }}">Previous</a>
                        @endif

                        @php
                            $startRange = max($farmers->currentPage() - 2, 1);
                            $endRange = min($farmers->currentPage() + 2, $farmers->lastPage());
                        @endphp

                        @if ($startRange > 1)
                            <a class="btn btn-default" href="{{ $farmers->url(1) }}">1</a>
                            @if ($startRange > 2)
                                <a class="btn btn-default" href="{{ $farmers->url(2) }}">2</a>
                                @if ($startRange > 3)
                                    <a class="btn btn-default" href="{{ $farmers->url($startRange - 1) }}">...</a>
                                @endif
                            @endif
                        @endif
                        @for ($page = $startRange; $page <= $endRange; $page++)
                            <a class="btn btn-{{ $farmers->currentPage() === $page ? 'primary' : 'default' }}"
                                href="{{ $farmers->url($page) }}">{{ $page }}</a>
                        @endfor
                        @if ($endRange < $farmers->lastPage() - 2)
                            <a class="btn btn-default" href="{{ $farmers->url($farmers->lastPage() - 3) }}">
                                ...
                            </a>
                        @endif
                        @if ($endRange < $farmers->lastPage())
                            @if ($endRange < $farmers->lastPage() - 1)
                                <a class="btn btn-default" href="{{ $farmers->url($farmers->lastPage() - 1) }}">
                                    {{ $farmers->lastPage() - 1 }}
                                </a>
                            @endif
                            <a class="btn btn-default" href="{{ $farmers->url($farmers->lastPage()) }}">
                                {{ $farmers->lastPage() }}
                            </a>
                        @endif
                        @if ($farmers->currentPage() < $farmers->lastPage())
                            <a class="btn btn-default" href="{{ $farmers->url($farmers->currentPage() + 1) }}">Next</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#FarmerTable').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
