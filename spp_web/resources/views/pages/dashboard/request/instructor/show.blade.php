@extends('layouts.app')

@section('title', 'Request')

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
        <form action="{{ route('dashboard.request.update', $datas['request']->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <fieldset @if ($datas['request']->status != 'pending') disabled @endif>
                    <x-form.input.text name="farmer_id" title="Kelompok Tani" :value="$datas['request']->farmer->name" :in-line="true"
                        :disabled="true" />
                    @if ($datas['request']->status == 'pending')
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
                                                    @if ($datas['request']->program)
                                                        Selected Program: {{ $datas['request']->program->division->name }} -
                                                        {{ $datas['request']->program->name }}
                                                    @else
                                                        Select Program
                                                    @endif
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="programAccordionCollapse" class="collapse"
                                        aria-labelledby="programAccordionHeading" data-parent="#programAccordion"
                                        style="max-height: 200px; overflow-y: auto; ">
                                        <div class="card-body">
                                            @foreach ($datas['programs'] as $program)
                                                <fieldset>
                                                    <legend>{{ $program['name'] }}</legend>
                                                    @include('partials.program-tree-view-select', [
                                                        'parent' => $program,
                                                        'selected' => $datas['request']->program_id,
                                                    ])
                                                </fieldset>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <x-form.input.text name="program_id" title="Kamus Usulan" :value="$datas['request']->program->name" :in-line="true"
                            :disabled="true" />
                    @endif
                    <x-form.input.number name="volume" title="volume" :value="$datas['request']->volume" :in-line="true" />
                    @if ($datas['request']->status == 'pending')
                        <x-form.input.option name="unit_id" title="Satuan" :options="$datas['units']" :in-line="true"
                            :selected="$datas['request']->unit_id" />
                    @else
                        <x-form.input.text name="unit_id" title="Satuan" :value="$datas['request']->unit->name" :in-line="true"
                            :disabled="true" />
                    @endif
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Data Pendukung</label>
                        <div class="col-sm-10">
                            @foreach ($datas['request']->attachments as $index => $attachment)
                                <div class="mb-2 attachment-name-group d-flex align-items-center form-group row">
                                    <input type="text" name="attachments[{{ $index }}][name]"
                                        class="mr-2 form-control col" value="{{ $attachment->name }}" disabled readonly>
                                    <a href="{{ Storage::url($attachment->url) }}" class="mr-1 btn btn-primary col-1"
                                        target="_blank">View</a>
                                    <a href="{{ route('dashboard.request.attachment.destroy', [$datas['request'], $attachment]) }}"
                                        class="btn btn-danger col-1">Delete</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tambah data pendukung</label>
                        <div class="col-sm-10" id="attachment_names_container">
                            <div class="mb-2 attachment-name-group d-flex align-items-center row">
                                <div class="col-5 form-group">
                                    <input type="text" name="attachments[][name]" class="form-control"
                                        placeholder="Attachment Name">
                                </div>
                                <div class="col-5 form-group">
                                    <div class="custom-file">
                                        <input type="file" name="attachments[][file]" class="custom-file-input"
                                            accept=".png, .jpg, .jpeg, .pdf">
                                        <label class="custom-file-label" for="attachment_files[]">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 offset-sm-2">
                            <button type="button" class="btn btn-secondary" id="add_attachment">Tambah file</button>
                        </div>
                    </div>
                </fieldset>
            </div>
            @if ($datas['request']->status == 'pending')
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            @endif
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
            var attachmentIndex = {{ count($datas['request']->attachments) }};

            $('#add_attachment').on('click', function() {
                var attachmentGroup = `
                <div class="mb-2 attachment-name-group d-flex align-items-center row">
                    <div class="col-5 form-group">
                        <input type="text" name="attachments[][name]" class="form-control" placeholder="Attachment Name">
                    </div>
                    <div class="col-5 form-group">
                        <div class="custom-file">
                            <input type="file" name="attachments[][file]" class="custom-file-input">
                            <label class="custom-file-label" for="attachment_files[]">Choose file</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger btn-remove-attachment">Remove</button>
                    </div>
                </div>
                `;
                $('#attachment_names_container').append(attachmentGroup);
                attachmentIndex++;
            });

            $(document).on('change', '.custom-file-input', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').text(fileName);
            });

            $(document).on('click', '.btn-remove-attachment', function() {
                $(this).closest('.attachment-name-group').remove();
            });
        });
    </script>
@endsection
