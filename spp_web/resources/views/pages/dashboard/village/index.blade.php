@extends('layouts.app')

@section('title', 'List Desa')

@section('css')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List Desa</h3>
            <div class="card-tools">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createVillageModal">
                    Tambah
                </button>

                <!-- Modal -->
                <div class="modal fade" id="createVillageModal" tabindex="-1" role="dialog"
                    aria-labelledby="createVillageModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createVillageModalLabel">Tambah Kecamatan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @if ($districts->count() == 1)
                                <form action="{{ route('dashboard.village.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <x-form.input.option name="district_id" title="Kecamatan" :options="$districts" />
                                        <x-form.input.text name="name" title="Nama Desa" />
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="with_user"
                                                    id="with_user" @checked(old('with_user')) value="true">
                                                <label class="custom-control-label" for="with_user">Buat akun Koor
                                                    Baru untuk desa ini.</label>
                                            </div>
                                        </div>
                                        @error('with_user')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            @else
                                <div class="m-2">
                                    Belum ada data Kecamatan tersimpan di database.<a
                                        href="{{ route('dashboard.district.index') }}">Klik di sini</a> untuk
                                    menambahkan data Kecamatan.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <x-table.datatable :table="$villageTable" />
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
                dropdownParent: $('#createVillageModal')
            });
        });
    </script>
@endsection
