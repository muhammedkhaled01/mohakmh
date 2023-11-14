@props(['name', 'mainoption' => false, 'options', 'innervalue' => false, 'label' => false, 'array' => false, 'oldvalue' => false])

@if ($label)
    <label for="">{{ $label }}</label>
@endif

<select name="{{ $name }}"
    {{ $attributes->class(['form-control', 'form-select', 'is_invalid' => $errors->has($name)]) }}
    {{ $attributes->style([]) }}>

    @if ($mainoption)
        <option value="">{{ $mainoption }}</option>
    @endif


    @if ($array) {{-- ان كان المدخل مصفوفة يدوي --}}
        @foreach ($options as $value => $label)
            <option value="{{ $value }}" @selected(old($name, $oldvalue) == $value)>{{ $label }}</option>
        @endforeach
    @else
        {{-- ان كان المدخل مصفوفة من قاعدة البيانات --}}
        @foreach ($options as $option)
            <option value="{{ $option->id }}" @selected(old($name, $innervalue) == $option->id)>{{ $option->name }}</option>
        @endforeach
    @endif

</select>
