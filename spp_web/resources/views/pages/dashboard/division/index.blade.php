@extends('layouts.app')

@section('title', 'List Bidang')

@section('css')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List Bidang</h3>
        <div class="card-tools">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createDivisionModal">
                Tambah
            </button>

            <!-- Modal -->
            <div class="modal fade" id="createDivisionModal" tabindex="-1" role="dialog"
                aria-labelledby="createDivisionModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createDivisionModalLabel">Tambah Kecamatan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('dashboard.setting.division.store') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <x-form.input.text name="name" title="Nama Bidang" />
                                <x-form.input.text name="nickname" title="Kode Bidang" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <x-table.datatable :table="$divisionTable" />
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
            dropdownParent: $('#createDivisionModal')
            });
        });
</script>
@endsection
