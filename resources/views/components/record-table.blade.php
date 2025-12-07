<div>
    <table>
        <thead>
            <tr>
                @foreach ($columns as $column)
                    <th class="px-4 py-2 text-left font-medium text-gray-700">{{ $column['label'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
                <tr class="border-t">
                    @foreach ($columns as $column)
                        <td class="px-4 py-2">
                            {{ $record->{$column['field']} }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>