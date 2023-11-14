<div class="form-group">
    <x-form.input label='اسم الكتاب' name='name' :value="$book->name" />
</div>
<div class="form-group">
    <x-form.select name='category_id' :options="$categories" :innervalue="$book->category_id" label='القسم' />
</div>
<div class="form-group">
    <x-form.select name='subCategory_id' :options="$subCategories" :innervalue="$book->subCategory_id" label='القسم الفرعي ' />
</div>
<div class="form-group">
    <x-form.select name='paid' :array=true :options="['1' => 'paid', '0' => 'free']" :oldvalue="$book->paid" label='مدفوع' />
</div>
<div class="form-group">
    <x-form.label id='file'>الملف</x-form.label>
    <x-form.input type="file" name="file" :bookid="$book_id" :existfile="$book->file" multiple />
</div>
<div class="form-group">
    <x-form.textarea label='الوصف' name='description' :value="$book->description" />
</div>
<div class="form-group">
    <x-form.textarea label='ملاحظات' name='note' :value="$book->note" />
</div>
<div class="form-group">
    <x-form.radio label='الحالة' name='status' :options="['active', 'archived']" :innervalue="$book->status" />
</div>
<div class="form-group">
    <x-form.button type='submit' btntype='success'>{{ $button_label ?? 'حفظ' }}</x-form.button>
</div>
