@props(['type' => 'submit', 'btntype' => 'success'])

<button type="{{ $type }}" {{ $attributes->class(["btn btn-$btntype"]) }}>{{ $slot }}</button>
