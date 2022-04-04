@php

    $thStyle = 'background-color: #444444; border: 1px solid #000000; color: #ffffff';
    $tdStyle = 'border: 1px solid #000000';

@endphp
<table>
    <thead>
    <tr>
        <th colspan="{{ count($headings) }}" style="background-color: #321fdb; color: #ffffff; font-size: 18px;">
            <strong>{{ $title }}</strong>
        </th>
    </tr>
    <tr>
        @foreach ($headings as $heading)
            <th style="{{ $thStyle }}; text-align: {{ $heading['align'] }}">
                <strong>{{ $heading['value'] }}</strong>
            </th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($records as $items)
        @php

            $tdColor = $loop->even ? '#eeeeee' : '#ffffff';

        @endphp
        <tr>
            @foreach ($items as $item)
                <td style="{{ $tdStyle }}; background-color: {{ $tdColor }}; text-align: {{ $item['align'] }}">
                    {{ $item['value'] }}
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
