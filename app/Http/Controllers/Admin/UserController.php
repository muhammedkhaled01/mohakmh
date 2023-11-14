<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orderBy = 'id';
        $direction = 'ASC';

        $itemsPerPage = $request->input('itemsPerPage', 10);
        if ($itemsPerPage <= 0 || $itemsPerPage > 50) {
            $itemsPerPage = 10;
        }
        if ($request->query('orderBy')) {
            $orderBy = $request->query('orderBy');
        }
        if ($request->query('direction')) {
            $direction = $request->query('direction');
        }
        // this is relation in model way to get parent name
        $users = User::with(['languages', 'profile', 'subscriptions'])->filter($request->query())
            ->orderBy($orderBy, $direction)
            ->paginate($itemsPerPage); // Return collection object work like array
        // return $users;
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        $packages = Package::all();
        return view('admin.users.create', compact('user', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return "done";
        // $clean_data فيها البيانات التي فحصت بنجاح فقط
        $clean_data = $request->validate(User::rules());

        // اضافة الملف
        $data = $request->except(['image', 'password']);
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request);
        }

        // تشفير كلمة المرور
        $data['password'] = Hash::make($request['password']);

        //اضافة تواقيت البطاقة المختارة
        $package = Package::where('id', $data['package_id'])->first();
        if ($package) {
            $currentDate = Carbon::now();
            $futureDate = $currentDate->addMonths($package->duration)->toDateString();
            $currentDate = Carbon::now()->toDateString();

            $data['package_start_at'] = $currentDate;
            // return gettype($data['package_start_at']);
            $data['package_end_at'] = $futureDate;
            // return [$currentDate, $futureDate];
        }
        // return $data;
        $user = User::create($data);

        foreach ($request->languages_name as $index => $language) {
            if ($language != null) {
                Language::create([
                    'user_id' => $user->id,
                    'name' => $language,
                    'level' => $request->languages_level[$index],
                ]);
            }
        }

        Profile::create([
            'user_id' => $user->id,
            'name_en' => $request->name_en,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'whatsapp' => $request->whatsapp,
            'nationality' => $request->nationality,
            'residence_country' => $request->residence_country,
        ]);

        return Redirect()->route('dashboard.users.index')->with('success', 'تم اضافة مستخدم جديد بنجاح'); // redirect will return object that have method route
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        try {
            $user = User::findOrFail($user->id);
        } catch (\Throwable $th) {
            //abort(404);
            return redirect()->route('dashboard.users.index')->with('info', 'هذا المستخدم غير موجود');
        }

        $packages = Package::all();
        return view('admin.users.edit', compact('user', 'packages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $clean_data = $request->validate(User::rules($user->id));
        try {
            $user = User::findOrFail($user->id);
            $profile = Profile::where('user_id', $user->id)->first();
            $all_language = Language::where('user_id', $user->id)->get();
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.users.index')->with('info', 'هذا المستخدم غير موجود');
        }

        // تحديث الملف
        $old_file = $user->image;
        $data = $request->except('image');

        // file upload
        if ($request->hasFile('image')) {
            $file = $this->uploadFile($request);
            $data['image'] = $file;
            if ($old_file) {
                Storage::disk('public')->delete($old_file);
            }
        };

        // اضافة بيانات البروفايل
        if (!$profile) {
            // ام كان المستخدم ليس لديه بروفايل
            Profile::create([
                'user_id' => $user->id,
                'name_en' => $request->name_en,
                'gender' => $request->gender,
                'birthdate' => $request->birthdate,
                'whatsapp' => $request->whatsapp,
                'nationality' => $request->nationality,
                'residence_country' => $request->residence_country,
            ]);
        } else {
            // تحيث البروفايل في حالة وجوده
            $profile->name_en = $request->name_en;
            $profile->gender = $request->gender;
            $profile->birthdate = $request->birthdate;
            $profile->whatsapp = $request->whatsapp;
            $profile->nationality = $request->nationality;
            $profile->residence_country = $request->residence_country;
            $profile->save();
        }

        // يتم فحص وجود لغات للمستخدم
        if ($all_language->isEmpty()) {
            // return $request->languages;
            foreach ($request->languages as $index => $language) {
                if ($language['name'] != null) {
                    Language::create([
                        'user_id' => $user->id,
                        'name' => $language['name'] ?? '', // في حالة المستخدم لم يدخل اسم اللغة
                        'level' => $language['level'] ?? 'معرفة', // في حالة المستخدم لم يدخل المستوى
                    ]);
                }
            }
        } else {
            foreach ($request->languages as $index => $language) {
                $languageToUpdate = $all_language[$index];
                $languageToUpdate->name = $language['name'] ?? ''; // في حالة المستخدم لم يدخل اسم اللغة
                $languageToUpdate->level = $language['level'] ?? 'معرفة'; // في حالة المستخدم لم يدخل المستوى
                $languageToUpdate->save();
                // }
            }
        }



        $user->update($data);
        return Redirect()->route('dashboard.users.index')->with('success', 'تم حديث المستخدم بنجاح!'); // redirect will return object that have method route
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // way 1
        $user = User::findOrFail($user->id);
        $profile = Profile::where('user_id', $user->id)->first();
        $language = Language::where('user_id', $user->id)->first();
        $currentuser = Auth::user();
        if ($currentuser->role == 'admin' && $user->role != 'user') {
            return Redirect()->route('dashboard.users.index')->with('danger', 'غير مصرح لك بالقيام بهذه العملية');
        }
        $user->delete();
        if ($profile) {
            $profile->delete();
        }
        if ($language) {
            $language->delete();
        }
        return Redirect()->route('dashboard.users.index')->with('danger', 'تم حذف المستخدم بنجاح!');
    }

    protected function uploadFile(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $file_name = time() . '-' . rand(5, 100) . rand(5, 100) .  '-' . $file->getClientOriginalName();
        $path = $file->move(public_path('storage/uploads/category-image'), $file_name);
        $file_name = 'uploads/category-image/' . $file_name;
        // $path = $file->storeAs('uploads/category-image', $file_name, 'public');
        return $file_name;
    }

    public function trash()
    {
        $users = User::onlyTrashed()->orderByDesc('deleted_at')->paginate();
        return view('admin.users.trash', compact('users'));
    }
    public function restore(Request $request, $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $profole = Profile::onlyTrashed()->where('user_id', $user->id);
        $language = Language::onlyTrashed()->where('user_id', $user->id);
        $user->restore();
        $profole->restore();
        $language->restore();
        return redirect()->route('dashboard.users.trash')->with('success', 'تم استعادة المستخدم بنجاح');
    }
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $profole = Profile::onlyTrashed()->where('user_id', $user->id);
        $language = Language::onlyTrashed()->where('user_id', $user->id);
        $currentuser = Auth::user();
        if ($currentuser->role == 'admin') {

            return Redirect()->route('dashboard.users.trash')->with('danger', 'غير مصرح لك بالقيام بهذه العملية');
        }
        $user->forceDelete();
        $profole->forceDelete();
        $language->forceDelete();
        return redirect()->route('dashboard.users.trash')->with('danger', 'تم حذف المستخدم بنجاح');
    }
}
