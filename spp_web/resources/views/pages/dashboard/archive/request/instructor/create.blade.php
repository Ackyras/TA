@extends('layouts.app')

@section('title', 'Create Request')

@section('css')
    <style>
        .subprograms-container {
            display: none;
        }
    </style>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <form action="{{ route('dashboard.request.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <x-form.input.option name="farmer_id" title="Kelompok Tani" :options="$datas['farmers']" :in-line="true"
                    id="farmer_id_option" :selected="old('farmer_id')" />
                <div class="form-group row">
                    <label for="program_id" class="col-sm-2 col-form-label">Kamus Usulan</label>
                    <div class="col-sm-10">
                        <div class="pl-0">
                            <div id="programAccordion" class="accordion">
                                <div class="card">
                                    <div class="card-header" id="programAccordionHeading">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#programAccordionCollapse" aria-expanded="false"
                                            aria-controls="programAccordionCollapse">
                                            Select Program
                                        </button>
                                    </div>
                                    <div id="programAccordionCollapse" class="collapse"
                                        aria-labelledby="programAccordionHeading" data-parent="#programAccordion">
                                        <div class="card-body">
                                            @foreach ($datas['programs'] as $program)
                                                @include('partials.tree-view-no-modal', [
                                                    'parent' => $program,
                                                    'selected' => old('program_id'),
                                                ])
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-form.input.number name="volume" title="Volume" :in-line="true" :value="old('volume')" />
                <x-form.input.option name="unit_id" title="Satuan" :options="$datas['units']" :in-line="true" :selected="old('unit_id')" />

                <div class="form-group">
                    <label for="attachments" class="col-form-label">Attachments</label>
                    <div id="attachments_container">
                        <div class="attachment-group">
                            <div class="attachment-name">
                                <input type="text" name="attachments[0][name]" class="form-control"
                                    placeholder="Attachment Name">
                            </div>
                            <div class="attachment-file">
                                <div class="custom-file">
                                    <input type="file" name="attachments[0][file]" class="custom-file-input"
                                        accept=".png, .jpg, .jpeg, .pdf">
                                    <label class="custom-file-label" for="attachments[0][file]">Choose file</label>
                                </div>
                            </div>
                            <div class="attachment-remove">
                                <button type="button" class="btn btn-danger remove-attachment">Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" id="add_attachment">Add Attachment</button>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.program-checkbox').on('change', function() {
                $('.program-checkbox').not(this).prop('checked', false);
                updateSelectProgramButton();
            });

            function updateSelectProgramButton() {
                var selectedProgram = $('.program-checkbox:checked').first();
                if (selectedProgram.length > 0) {
                    var programName = selectedProgram.data('program-name');
                    $('#programAccordionHeading button').text('Selected Program: ' + programName);
                } else {
                    $('#programAccordionHeading button').text('Select Program');
                }
            }
        });

        $(document).ready(function() {
            $('#select2').select2({
                theme: 'bootstrap4',
                width: 'resolve'
            });
        });
        $(document).ready(function() {
            $('#farmer_id_option').select2({
                theme: 'bootstrap4',
                width: 'resolve'
            });
        });

        $(document).ready(function() {
            $('#add_attachment').on('click', function() {
                var attachmentIndex = $('.attachment-group').length;
                var attachmentGroup = `
                    <div class="attachment-group">
                        <div class="attachment-name">
                            <input type="text" name="attachments[${attachmentIndex}][name]" class="form-control"
                                placeholder="Attachment Name">
                        </div>
                        <div class="attachment-file">
                            <div class="custom-file">
                                <input type="file" name="attachments[${attachmentIndex}][file]" class="custom-file-input" accept=".png, .jpg, .jpeg, .pdf">
                                <label class="custom-file-label" for="attachments[${attachmentIndex}][file]">Choose file</label>
                            </div>
                        </div>
                        <div class="attachment-remove">
                            <button type="button" class="btn btn-danger remove-attachment">Remove</button>
                        </div>
                    </div>
                `;
                $('#attachments_container').append(attachmentGroup);
            });

            $(document).on('change', '.custom-file-input', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').text(fileName);
            });

            $(document).on('click', '.remove-attachment', function() {
                $(this).closest('.attachment-group').remove();
            });
        });
    </script>
@endsection
