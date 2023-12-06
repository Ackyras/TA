@extends('layouts.app')

@section('title', 'List Kelompok Tani')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List Kelompok Tani</h3>
            <div class="card-tools">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createFarmerModal">
                    Tambah Kelompok Tani
                </button>
                <!-- Modal -->
                <div class="modal fade" id="createFarmerModal" tabindex="-1" role="dialog"
                    aria-labelledby="createFarmerModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createFarmerModalLabel">Tambah Kelompok Tani</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('dashboard.farmer.store') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <x-form.input.text name="name" title="Nama Kelompok Tani" />
                                    <x-form.input.text name="address" title="Alamat" />
                                    <x-form.input.text name="pic" title="PIC" />
                                    <x-form.input.option name="village_id" title="Desa" :options="$villages"
                                        :selected="old('village_id')" />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.farmer.index') }}" method="GET" class="mb-3">
                <div class="border-0 card">
                    <div class="p-2 card-header" data-toggle="collapse" data-target="#filterCard" aria-expanded="false"
                        aria-controls="filterCard">
                        <a class="mb-0 card-title font-weight-bold">Filter</a>
                        <button class="float-right p-0 btn btn-link btn-sm" type="button" data-toggle="collapse"
                            data-target="#filterCard" aria-expanded="false" aria-controls="filterCard">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div id="filterCard" class="collapse">
                        <div class="p-2 card-body">
                            <x-form.input.text name="filter[name]" title="Name" :value="request()->input('filter.name')" :in-line="true" />
                            <x-form.input.text name="filter[pic]" title="PIC" :value="request()->input('filter.pic')" :in-line="true" />
                        </div>
                        <div class="p-2 card-footer d-flex justify-content-end">
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
                        <th>Desa, Kecamatan</th>
                        <th>PIC</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($farmers as $farmer)
                        <tr>
                            <td>{{ $farmer->name }}</td>
                            <td>{{ $farmer->address }}</td>
                            <td>
                                <a
                                    href="{{ route('dashboard.village.show', ['village' => $farmer->village->id]) }}">{{ $farmer->village->name }}</a>,
                                <a
                                    href="{{ route('dashboard.district.show', ['district' => $farmer->village->district->id]) }}">{{ $farmer->village->district->name }}</a>
                            </td>
                            <td>{{ $farmer->pic }}</td>
                            <td>
                                <a href="{{ route('dashboard.farmer.show', $farmer) }}" class="btn btn-primary">Lihat</a>
                                <form action="{{ route('dashboard.farmer.destroy', $farmer) }}" method="POST"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 d-flex justify-content-between">
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
