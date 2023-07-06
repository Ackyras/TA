<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
    <table id="{{ $id }}" class="table table-bordered table-hover">
        <caption>{{ $table['caption'] }}</caption>
        <thead>
            <tr>
                @foreach ($table['headers'] as $key=>$header)
                <th>{{ str()->title($key) }}</th>
                @endforeach
                @isset ($table['actions'])
                <th>Aksi</th>
                @endisset
            </tr>
        </thead>
        <tbody>
            @foreach ($table['rows'] as $row)
            <tr>
                @foreach ($table['headers'] as $key => $header)
                <td>
                    @isset($row[$header])
                    {{ $row[$header] }}
                    @endisset
                </td>
                @endforeach
                @isset ($table['actions'])
                <td class="d-flex d-inline-block">
                    @foreach ($table['actions'] as $action)
                    <x-button :text="$action['text']" :type="$action['type']"
                        :route="route($action['route'], $getActionParameter($action, $row))"
                        :color="$action['color']" />
                    @endforeach
                </td>
                @endisset
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stack('script')