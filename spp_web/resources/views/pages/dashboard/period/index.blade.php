@extends('layouts.app')

@section('title', 'List Period')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List</h3>
            <div class="card-tools">
                <button class="btn btn-primary" data-toggle="modal" data-target="#createPeriodModal">Create Period</button>
            </div>
        </div>
        <div class="card-body">
            <x-table.datatable :table="$periods" />
        </div>
    </div>

    <!-- Create Period Modal -->
    <div class="modal fade" id="createPeriodModal" tabindex="-1" role="dialog" aria-labelledby="createPeriodModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPeriodModalLabel">Create New Period</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('dashboard.setting.period.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input name="name" type="text" class="form-control" id="name"
                                placeholder="Enter name" value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input name="start_date" type="date" class="form-control datepicker" id="start_date"
                                placeholder="Select start date" value="{{ old('start_date') }}">
                        </div>
                        @error('start_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input name="end_date" type="date" class="form-control datepicker" id="end_date"
                                placeholder="Select end date" value="{{ old('end_date') }}">
                        </div>
                        @error('end_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="deactivate_active_period"
                                    id="deactivate_active_period" @checked(old('deactivate_active_period'))>
                                <label class="custom-control-label" for="deactivate_active_period">Jadikan periode baru
                                    sebagai periode aktif, dan
                                    nonaktifkan periode lama.</label>
                            </div>
                        </div>
                        @error('deactivate_active_period')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
