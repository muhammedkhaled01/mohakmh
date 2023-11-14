<div class="form-group ">
    <x-form.input label='الاسم الاول' name='firstName' :value="$form->firstName" readonly />
    <x-form.input label='الاسم الاخير' name='lastName' :value="$form->lastName"readonly />
</div>

<div class="form-group">
    <x-form.input label='الايميل' name='email' :value="$form->email" readonly />
</div>

<div class="form-group">
    <x-form.input label='الموضوع' name='subject' :value="$form->subject"readonly />
    <x-form.input label='الهدف' name='purpos' :value="$form->purpos" readonly />
</div>

<div class="form-group">
    <x-form.textarea label='الرسالة' name='message' :value="$form->message" readonly />
</div>
<div class="form-group">
    <x-form.textarea label='ملاحظات' name='note' :value="$form->note" />
</div>

<div class="form-group">
    <x-form.label id="reply">{{ 'حالة الرد' }}</x-form.label>
    <x-form.select name='reply' array="yes" :options="['1' => 'تم الرد', '0' => 'قيد الانتظار']" :innervalue="$form->reply" />
</div>

<div class="form-group">
    <x-form.button type='submit' btntype='success'>{{ $button_label ?? 'حفظ' }}</x-form.button>
</div>
