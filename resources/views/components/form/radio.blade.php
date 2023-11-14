@props(['name', 'options', 'innervalue', 'label'])

<label for="">{{ $label }}</label>
@foreach ($options as $value)
    <div class="form-check">
        <input type="radio" name="{{ $name }}" value="{{ $value }}" @checked(old($name, $innervalue) == $value)
            {{ $attributes->class(['form-check-input', 'is-invalid' => $errors->has($name)]) }}>
        <label class="form-check-label">
            {{ $value }}
        </label>
    </div>
@endforeach
