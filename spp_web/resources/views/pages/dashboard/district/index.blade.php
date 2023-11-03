@extends('layouts.app')

@section('title', 'List Kecamatan')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List</h3>
            <div class="card-tools">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createDistrictModal">
                    Tambah
                </button>

                <!-- Modal -->
                <div class="modal fade" id="createDistrictModal" tabindex="-1" role="dialog"
                    aria-labelledby="createDistrictModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createDistrictModalLabel">Tambah Kecamatan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('dashboard.district.store') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <x-form.input.text name="name" title="Nama Kecamatan" />
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <x-table.datatable :table="$districtTable" />
        </div>
    </div>
@endsection
