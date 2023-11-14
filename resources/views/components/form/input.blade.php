@props(['type' => 'text', 'name', 'value' => '', 'label' => false, 'existfile' => false, 'existimage' => false, 'bookid' => false])

@if ($label)
    <label for="">{{ $label }}</label>
@endif
<input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>

@error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror

@if ($existimage)
    <img src="{{ asset('storage/' . $existimage) }}" alt="old image" height="60">
@endif

@if ($existfile)
    <a href="{{ route('dashboard.books.view', $bookid) }}" target="_blank">عرض الكتاب</a>
@endif
