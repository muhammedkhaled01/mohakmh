<div class="form-group">
    <x-form.input label='اسم القسم' name='name' :value="$category->name" />
</div>
<div class="form-group">
    <x-form.label id='image'>الصورة</x-form.label>
    <x-form.input type="file" name="image" :existimage="$category->image" />
</div>
<div class="form-group">
    <x-form.select name='parent_id' mainoption='Primary Category' :options="$parents" :innervalue="$category->parent_id"
        label='القسم الأب' />
</div>
<div class="form-group">
    <x-form.textarea label='ملاحظات' name='note' :value="$category->note" />
</div>
<div class="form-group">
    <x-form.radio label='الحالة' name='status' :options="['active', 'archived']" :innervalue="$category->status" />
</div>
<div class="form-group">
    <x-form.button type='submit' btntype='success'>{{ $button_label ?? 'حفظ' }}</x-form.button>
</div>
