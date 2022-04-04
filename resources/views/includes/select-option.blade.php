@php

    if (!isset($selected)) {
        $selected = null;
    }

@endphp
<option></option>
@foreach ($items as $value => $label)
    <option value="{{ $value }}" {{ (string)$value === (string)$selected ? 'selected' : '' }}>{{ $label }}</option>
@endforeach