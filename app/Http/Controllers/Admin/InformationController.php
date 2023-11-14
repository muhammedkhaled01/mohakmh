<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformationController extends Controller
{
    public function index(Request $request)
    {
        $informations = Information::all();
        return view('admin.informations.index', compact('informations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $information = new Information();
        return view('admin.informations.create', compact('information'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $clean_data فيها البيانات التي فحصت بنجاح فقط
        $clean_data = $request->validate(Information::rules(), [
            'unique' => 'هذا  (:attribute) موجود بالفعل!',
            'required' => 'هذا الحقل مطلوب',
        ]);
        $informations = Information::create($request->all());
        return Redirect()->route('dashboard.informations.index')->with('success', 'تم انشاء معلومات تواصل جديدة بنجاح'); // redirect will return object that have method route
    }

    public function show(Information $informations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information $information)
    {
        try {
            $information = Information::findOrFail($information->id);
        } catch (\Throwable $th) {
            //abort(404);
            return redirect()->route('admin.informations.index')->with('info', 'هذه المعلومات غير موجودة');
        }

        return view('admin.informations.edit', compact('information'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Information $information)
    {
        $request->validate(Information::rules());
        try {
            $information = Information::findOrFail($information->id);
        } catch (\Throwable $th) {
            return redirect()->route('admin.informations.index')->with('info', 'هذه المعلومات غير موجودة');
        }
        $information->update($request->all());
        return Redirect()->route('dashboard.informations.index')->with('success', 'تم حديث المعلومات بنجاح!'); // redirect will return object that have method route
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information)
    {
        $information = Information::findOrFail($information->id);
        $information->delete();
        return Redirect()->route('dashboard.informations.index')->with('danger', 'تم حذف المعلومات بنجاح!');
    }
}
