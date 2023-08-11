@extends('layouts.app')

@section('title', 'List Kamus Usulan')

@section('css')
    <style>
        .subprogram-item:hover {
            background-color: #f0f0f0;
        }
    </style>
@endsection

@section('content')
    @error('is_parent')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title">List Kamus Usulan</h3>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createProgramModal">
                        Tambah Program
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="program-tree">
                @forelse ($programs as $program)
                    @include('partials.dictionary_tree', ['parent' => $program])
                @empty
                    Belum ada data Program Pengadaan tersimpan.
                @endforelse
            </div>
        </div>
    </div>

    <!-- Create Program Modal -->
    <div class="modal fade" id="createProgramModal" tabindex="-1" role="dialog" aria-labelledby="createProgramModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProgramModalLabel">Tambah Program</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.setting.program.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" name="code" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <!-- Select2 -->
    <script src="{{ asset('adminLTE/plugins/select2/js/select2.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#select2').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#createProgramModal')
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#programtable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection


{{-- @forelse ($divisions as $division)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Kamus Usulan {{ $division['name'] }}</h3>
                                <div class="card-tools">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="ml-auto btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#createProgramModal_{{ $division['id'] }}">
                                        <span class="d-none d-md-inline">Tambah</span>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="createProgramModal_{{ $division['id'] }}" tabindex="-1"
                                        role="dialog" aria-labelledby="createProgramModal_{{ $division['id'] }}Label"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="createProgramModal_{{ $division['id'] }}Label">
                                                        Tambah Program Kamus Usulan Utama
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('dashboard.setting.program.store') }}"
                                                    method="POST">
                                                    @csrf
                                                    <x-form.input.hidden name='division_id' :value="$division['id']" />
                                                    <x-form.input.hidden name='is_parent' :value="true" />
                                                    <div class="modal-body">
                                                        <x-form.input.text name="code" title="Kode Kamus Usulan" />
                                                    </div>
                                                    <div class="modal-body">
                                                        <x-form.input.text name="name" title="Nama Kamus Usulan" />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./card-header -->
                            <div class="p-2 card-body">
                                @each('partials.tree-view', $division['programs'], 'parent')
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            @empty
                Anda tidak bisa membuat Kamus Usulan tanpa Bidang Pengadaan bantuan. <a
                    href="{{ route('dashboard.setting.division.index') }}">Klik di sini</a> untuk membuat Bidang Terlebih
                Dahulu!
            @endforelse --}}
