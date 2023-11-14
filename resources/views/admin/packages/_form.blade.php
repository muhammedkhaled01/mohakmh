<div class="form-group">
    <x-form.input label='اسم الباقة' name='name' :value="$package->name" />
</div>
<div class="form-group">
    <x-form.input type="number" label='السعر' name='price' :value="$package->price" />
</div>
<div class="form-group">
    <x-form.input type="number" label='السعر الجديد' name='new_price' :value="$package->new_price" />
</div>
<div class="form-group">
    <x-form.input type="number" label='المدة / بالشهر' name='duration' :value="$package->duration" />
</div>
<div class="form-group">
    <x-form.input type="number" label='مدة الخصم' name='free_duration' :value="$package->free_duration" />
</div>

@if ($action == 'create' || $package->advantages->isEmpty())
    <div class="form-group">
        <x-form.input label='ميزة' name="advantages[0]" />
    </div>
    <div class="form-group">
        <x-form.input label='ميزة' name="advantages[1]" />
    </div>
    <div class="form-group">
        <x-form.input label='ميزة' name="advantages[2]" />
    </div>
    <div class="form-group">
        <x-form.input label='ميزة' name="advantages[3]" />
    </div>
@endif

@foreach ($package->advantages as $index => $advantage)
    <div class="form-group">
        <x-form.input label='ميزة' name="advantages[{{ $index }}][text]" :value="$advantage->text" />
    </div>
@endforeach

<div class="form-group">
    <x-form.textarea label='ملاحظات' name='note' :value="$package->note" />
</div>
<div class="form-group">
    <x-form.radio label='الحالة' name='status' :options="['active', 'archived']" :innervalue="$package->status" />
</div>
<div class="form-group">
    <x-form.button type='submit' btntype='success'>{{ $button_label ?? 'حفظ' }}</x-form.button>
</div>
