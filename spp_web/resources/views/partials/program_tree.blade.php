<div class="px-3 py-2 subprogram-item">
    <div class="d-flex align-items-center">
        <!-- Display necessary icons and information about the program here -->
        @isset($parent->parent_id)
            <i class="mr-2 fas fa-level-up-alt" style="transform: rotate(90deg);"></i>
        @endisset
        @if (isset($parent->lowerProgramTree))
            <strong>
                {{ $parent['code'] }}:{{ $parent['name'] }}
            </strong>
        @endif


        <div class="ml-auto">
            <!-- Display buttons and modals for creating, editing, and deleting programs here -->
            <div class="row">
                <div class="col-auto">
                    <button type="button" class="p-0 btn btn-sm btn-light rounded-circle" data-toggle="modal"
                        data-target="#createSubProgramModal_{{ $parent['id'] }}">
                        <i class="fas fa-plus text-primary"></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="createSubProgramModal_{{ $parent['id'] }}" tabindex="-1" role="dialog"
                        aria-labelledby="createSubProgramModal_{{ $parent['id'] }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createSubProgramModal_{{ $parent['id'] }}Label">
                                        Tambah
                                        Sub
                                        Program
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('dashboard.setting.program.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <x-form.input.hidden name='parent_id' :value="$parent['id']" />
                                        <x-form.input.text name="code" title="Kode Kamus Usulan" :value="$parent['code'] . '.'" />
                                        <x-form.input.text name="name" title="Nama Kamus Usulan" />
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-auto">
                    <button type="button" class="p-0 btn btn-sm btn-light rounded-circle" data-toggle="modal"
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
                                <form action="{{ route('dashboard.setting.program.update', $parent['id']) }}"
                                    method="POST">
                                    <div class="modal-body">
                                        @csrf
                                        @method('PUT')
                                        <x-form.input.text name="code" title="Kode Kamus Usulan" :value="$parent['code']" />
                                        <x-form.input.text name=" name" title="Nama Kamus Usulan" :value="$parent['name']" />
                                    </div>
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

                <div class="col-auto">
                    <form action="{{ route('dashboard.setting.program.destroy', $parent['id']) }}" method="POST"
                        @if ($parent['is_parent']) onsubmit="return confirm('Seluruh Sub-Program juga akan ikut terhapus, anda yakin?');" @else
                        onsubmit="return confirm('Yakin ingin menghapus Sub-Program?');" @endif>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-0 btn btn-sm btn-light rounded-circle">
                            <i class="fas fa-trash text-danger"></i>
                        </button>
                    </form>
                </div>
            </div>
            {{-- <!-- Check if the program has proposalDictionaries -->
            @if ($parent->proposalDictionaries->isNotEmpty())
                <div class="pl-4">
                    <!-- Display the proposalDictionaries for this program -->
                    @foreach ($parent->proposalDictionaries as $dictionary)
                        <!-- You can customize how each dictionary is displayed -->
                        <div>{{ $dictionary->some_attribute }}</div>
                    @endforeach
                </div>
            @endif --}}
        </div>
    </div>
</div>

<!-- Recursively display lowerProgramTree -->
@if ($parent->lowerProgramTree->isNotEmpty())
    <div class="pl-4">
        @each('partials.program_tree', $parent->lowerProgramTree, 'parent')
    </div>
@endif
