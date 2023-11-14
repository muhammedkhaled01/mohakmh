<div class="form-group">
    <x-form.input label='اسم المستخدم' name='name' :value="$user->name" />
</div>
<div class="form-group">
    <x-form.input type="email" label='الايميل' name='email' :value="$user->email" />
</div>
@if ($action == 'create')
    <div class="form-group">
        <x-form.input type="password" label='كلمة المرور' name='password' :value="$user->password" />
    </div>
@endif
<div class="form-group">
    <x-form.input type="number" label='رقم الهاتف' name='phone_number' :value="$user->phone_number" />
</div>
<div class="form-group">
    <x-form.select name='package_id' :options="$packages" mainoption="بلا" :innervalue="$user->package_id" label='الباقة' />
</div>
<div class="form-group">
    <x-form.label id='image'>الصورة</x-form.label>
    <x-form.input type="file" name="image" :existimage="$user->image" />
</div>

<div class="form-group">
    <x-form.radio label='الرتبة' name='role' :options="['user', 'admin']" :innervalue="$user->role" />
</div>
<div class="form-group">
    <x-form.textarea label='ملاحظات' name='note' :value="$user->note" />
</div>
<div class="form-group">
    <x-form.radio label='الحالة' name='status' :options="['active', 'archived']" :innervalue="$user->status" />
</div>

@if ($user->role == 'user')
@endif
<div>
    <h2>بيانات الملف الشخصي للمستخدم</h2>
</div>
<br>

<div class="form-group">
    <x-form.input label='الاسم بالانجليزي' name='name_en' :value="$user->profile->name_en" />
</div>
<div class="form-group">
    <x-form.radio label='الجندر' name='gender' :options="['male', 'female']" :innervalue="$user->profile->gender" />
</div>
<div class="form-group">
    <x-form.input type='date' label='تاريخ الميلاد' name='birthdate' :value="$user->profile->birthdate" />
</div>
<div class="form-group">
    <x-form.input typey="number" label='رقم الواتساب' name='whatsapp' :value="$user->profile->whatsapp" />
</div>
<div class="form-group">
    <x-form.input label='الجنسية' name='nationality' :value="$user->profile->nationality" />
</div>
<div class="form-group">
    <x-form.input label='بلد الاقامة' name='residence_country' :value="$user->profile->residence_country" />
</div>

@if ($action == 'create' || $user->languages->isEmpty())
    <div class="form-group">
        <x-form.input label='اللغة' name='languages[0][name]' />
    </div>
    <div class="form-group">
        <x-form.radio label='مستوى اللغة' name='languages[0][level]' :options="['معرفة', 'قراءة', 'كتابة', 'بطلاقة']" :innervalue=null />
    </div>
    <div class="form-group">
        <x-form.input label='اللغة' name='languages[1][name]' />
    </div>
    <div class="form-group">
        <x-form.radio label='مستوى اللغة' name='languages[1][level]' :options="['معرفة', 'قراءة', 'كتابة', 'بطلاقة']" :innervalue=null />
    </div>
@endif


@foreach ($user->languages as $index => $language)
    <div class="form-group">
        <x-form.input label='اللغة' name='languages[{{ $index }}][name]' :value="$language->name" />
    </div>
    <div class="form-group">
        <x-form.radio label='مستوى اللغة' name='languages[{{ $index }}][level]' :options="['معرفة', 'قراءة', 'كتابة', 'بطلاقة']"
            :innervalue="$language->level" />
    </div>
@endforeach


@foreach ($user->subscriptions as $subscription)
    <div class="form-group">
        <x-form.input label='الباقة' name='package_name' :value="$subscription->package->name" readonly />
    </div>
    <div class="form-group">
        <x-form.input label='تبدا في' name='start_at' :value="$subscription->start_at" readonly />
    </div>
    <div class="form-group">
        <x-form.input label='تنتهي في' name='end_at' :value="$subscription->end_at" readonly />
    </div>
@endforeach


<div class="form-group">
    <x-form.button type='submit' btntype='success'>{{ $button_label ?? 'حفظ' }}</x-form.button>
</div>
