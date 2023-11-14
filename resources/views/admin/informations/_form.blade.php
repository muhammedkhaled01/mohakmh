<div class="form-group">
    <x-form.input label='المقولة' name='sentence' :value="$information->sentence" />
</div>
<div class="form-group">
    <x-form.input label='العنوان' name='title' :value="$information->title" />
</div>
<div class="form-group">
    <x-form.input label='المكان' name='address' :value="$information->address" />
</div>
<div class="form-group">
    <x-form.input label='الايميل' name='email' :value="$information->email" />
</div>
<div class="form-group">
    <x-form.input label='رقم الهاتف' name='phone' :value="$information->phone" />
</div>

<div class="form-group">
    <x-form.input label='الفيسبوك' name='facebook' :value="$information->facebook" />
</div>
<div class="form-group">
    <x-form.input label='الانتسقرام' name='instagram' :value="$information->instagram" />
</div>
<div class="form-group">
    <x-form.input label='تويتر (x)' name='x' :value="$information->x" />
</div>
<div class="form-group">
    <x-form.input label='لينكيد ان' name='linkedin' :value="$information->linkedin" />
</div>
<div class="form-group">
    <x-form.input label='ملاحظات' name='note' :value="$information->note" />
</div>

<div class="form-group">
    <x-form.button type='submit' btntype='success'>{{ $button_label ?? 'حفظ' }}</x-form.button>
</div>
