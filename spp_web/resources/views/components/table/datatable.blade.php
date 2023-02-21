<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
    <table id="datatable" class="table table-bordered table-hover">
        <caption>{{ $table['caption'] }}</caption>
        <thead>
            <tr>
                @foreach ($table['headers'] as $header)
                <th>{{ $header }}</th>
                @endforeach
                @if ($table['actions'])
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($table['rows'] as $row)
            <tr>
                @foreach ($table['headers'] as $key => $header)
                <td>{{ $row[$header] }}</td>
                @endforeach
                @if ($table['actions'])
                <td class="d-flex d-inline-block">
                    @foreach ($table['actions'] as $action)
                    <x-button :text="$action['text']" :type="$action['type']"
                        :route="route($action['route'], $getActionParameter($action, $row))"
                        :color="$action['color']" />
                    @endforeach
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stack('script')