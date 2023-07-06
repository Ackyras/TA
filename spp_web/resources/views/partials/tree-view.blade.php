<div class="px-3 py-2 subprogram-item">
    <div class="d-flex align-items-center">
        @isset($parent['parent_id'])
        <i class="fas fa-level-up-alt mr-2" style="transform: rotate(90deg);"></i>
        @endisset
        @if($parent['is_parent'])
        <strong>
            {{ $parent['code'] }}:{{ $parent['name'] }}
        </strong>
        @else
        {{ $parent['name'] }}
        @endif
        <div class="ml-auto">
            <div class="row">
                @if($parent['is_parent'])
                <div class="col-auto">
                    <button type="button" class="btn btn-sm btn-light rounded-circle p-0" data-toggle="modal"
                        data-target="#createSubProgramModal_{{ $parent['id'] }}">
                        <i class="fas fa-plus text-primary"></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="createSubProgramModal_{{ $parent['id'] }}" tabindex="-1" role="dialog"
                        aria-labelledby="createSubProgramModal_{{ $parent['id'] }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createSubProgramModal_{{ $parent['id'] }}Label">Tambah
                                        Sub
                                        Program
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('dashboard.setting.program.store') }}" method="POST">
                                        @csrf
                                        <x-form.input.hidden name='division_id' :value="$parent['division_id']" />
                                        <x-form.input.hidden name='parent_id' :value="$parent['id']" />
                                        <x-form.input.text name="code" title="Kode Kamus Usulan"
                                            :value="$parent['code']. '.'" />
                                        <x-form.input.text name="name" title="Nama Kamus Usulan" />
                                        <x-form.input.checkbox value="{{ true }}" name="is_parent"
                                            title="Punya subProgram" />
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
                @endif

                <div class="col-auto">
                    <button type="button" class="btn btn-sm btn-light rounded-circle p-0" data-toggle="modal"
                        data-target="#editSubProgram_{{ $parent['id'] }}">
                        <i class="fas fa-edit text-info"></i>
                    </button>

                    <div class="modal fade" id="editSubProgram_{{ $parent['id'] }}" tabindex="-1" role="dialog"
                        aria-labelledby="editSubProgram_{{ $parent['id'] }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editSubProgram_{{ $parent['id'] }}Label">Perbarui Sub
                                        Program
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('dashboard.setting.program.update', $parent['id']) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        @if ($parent['is_parent'])
                                        <x-form.input.text name="code" title="Kode Kamus Usulan"
                                            :value="$parent['code']" :disabled="true" />
                                        @endif
                                        <x-form.input.text name=" name" title="Nama Kamus Usulan"
                                            :value="$parent['name']" />
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-info">Perbarui</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-auto">
                    <form action="{{ route('dashboard.setting.program.destroy', $parent['id']) }}" method="POST"
                        @if($parent['is_parent'])
                        onsubmit="return confirm('Seluruh Sub-Program juga akan ikut terhapus, anda yakin?');" @else
                        onsubmit="return confirm('Yakin ingin menghapus Sub-Program?');" @endif>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-light rounded-circle p-0">
                            <i class="fas fa-trash text-danger"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@isset($parent['lower_program_tree'])
<div class="pl-4">
    @each('partials.tree-view', $parent['lower_program_tree'], 'parent')
</div>
@endisset

{{-- <div class="px-3 py-2 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        @isset($parent['parent_id'])
        <i class="fas fa-level-up-alt mr-2" style="transform: rotate(90deg);"></i>
        @endisset
        @if($parent['is_parent'])
        <strong>
            {{ $parent['code'] }}:{{ $parent['name'] }}
        </strong>
        @else
        {{ $parent['name'] }}
        @endif
    </div>
    @if($parent['is_parent'])
    <div>
        <button type="button" class="btn btn-sm btn-light rounded-circle p-0" data-toggle="modal"
            data-target="#createSubProgramModal_{{ $parent['id'] }}">
            <i class="fas fa-plus text-primary"></i>
        </button>
        <button type="button" class="btn btn-sm btn-light rounded-circle p-0" data-toggle="modal"
            data-target="#editSubProgram_{{ $parent['id'] }}">
            <i class="fas fa-edit text-info"></i>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="createSubProgramModal_{{ $parent['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="createSubProgramModal_{{ $parent['id'] }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSubProgramModal_{{ $parent['id'] }}Label">Tambah Sub Program
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('dashboard.setting.program.store') }}" method="POST">
                            @csrf
                            <x-form.input.hidden name='division_id' :value="$parent['division_id']" />
                            @unless($parent['parent_id']==null)
                            <x-form.input.hidden name='parent_id' :value="$parent['id']" />
                            @endunless
                            <x-form.input.text name="code" title="Kode Kamus Usulan" :value="$parent['code']. '.'" />
                            <x-form.input.text name="name" title="Nama Kamus Usulan" />
                            <x-form.input.checkbox value="{{ true }}" name="is_parent" title="Punya subProgram" />
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editSubProgram_{{ $parent['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="editSubProgram_{{ $parent['id'] }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSubProgram_{{ $parent['id'] }}Label">Tambah Sub Program
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('dashboard.setting.program.store') }}" method="POST">
                            @csrf
                            <x-form.input.text name="code" title="Kode Kamus Usulan" :value="$parent['code']"
                                :disabled="true" />
                            <x-form.input.text name=" name" title="Nama Kamus Usulan" :value="$parent['name']" />
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@isset($parent['lower_program_tree'])
<div class="pl-4">
    @each('partials.tree-view', $parent['lower_program_tree'], 'parent')
</div>
@endisset --}}