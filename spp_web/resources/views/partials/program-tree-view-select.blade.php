<div class="px-3 py-2 subprogram-item" onmouseover="this.style.backgroundColor='#f5f5f5';"
    onmouseout="this.style.backgroundColor='transparent';">
    <div class="d-flex align-items-center" onclick="toggleCheckbox(event);">
        @isset($parent['parent_id'])
            <i class="fas fa-level-up-alt mr-2" style="transform: rotate(90deg);"></i>
        @endisset
        @if ($parent['is_parent'])
            <strong>
                {{ $parent['code'] }}:{{ $parent['name'] }}
            </strong>
        @else
            <input type="radio" name="filter[program_id]" value="{{ $parent['id'] }}"
                @if ($parent['id'] == $selected) checked @endif>
            {{ $parent['name'] }}
        @endif
    </div>
</div>

@isset($parent['lower_program_tree'])
    <div class="pl-4">
        @foreach ($parent['lower_program_tree'] as $program)
            @include('partials.program-tree-view-select', [
                'parent' => $program,
                'selected' => $selected,
            ])
        @endforeach
    </div>
@endisset

<script>
    function toggleCheckbox(event) {
        var checkbox = event.target.querySelector('input[type="radio"]');
        if (checkbox) {
            checkbox.checked = !checkbox.checked;
        }
    }
</script>
