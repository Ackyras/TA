@extends('layouts.app')

@section('title', 'List Kamus Usulan')

@section('css')
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">List Kamus Usulan</h3>
    </div>
    <div class="card-body">
        @foreach ($divisions as $division)
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
                                            <h5 class="modal-title" id="createProgramModal_{{ $division['id'] }}Label">
                                                Tambah Program Kamus Usulan Utama
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('dashboard.setting.program.store') }}" method="POST">
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
                    <div class="p-0 card-body">
                        <table class="table table-hover">
                            <tbody>
                                @isset($division['programs'])
                                @each('components.tree-view', $division['programs'], 'parent')
                                @endisset
                            </tbody>
                        </table>
                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        @endforeach
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
                "ordering" : false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
</script>
@endsection