<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
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
        $forms = Form::filter($request->query())
            ->orderBy($orderBy, $direction)
            ->paginate($itemsPerPage); // Return collection object work like array

        return view('admin.forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        try {
            $form = Form::findOrFail($form->id);
        } catch (\Throwable $th) {
            return redirect()->route('admin.forms.index')->with('info', 'هذه الرسالة غير موجودة');
        }

        return view('admin.forms.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Form $form)
    {
        $request->validate([
            'reply' => 'required',
            'note' => 'nullable',
        ]);
        try {
            $form = Form::findOrFail($form->id);
        } catch (\Throwable $th) {
            return redirect()->route('admin.forms.index')->with('info', 'هذه الرسالة غير موجودة');
        }
        $form->reply = $request->reply;
        if ($request->note) {
            $form->note = $request->note;
        }
        $form->save();
        return Redirect()->route('dashboard.forms.index')->with('success', 'تم التحديث  بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        $form = Form::findOrFail($form->id);
        $form->delete();
        return Redirect()->route('dashboard.forms.index')->with('danger', 'تم حذف الرسالة بنجاح!');
    }

    public function trash()
    {
        $forms = Form::onlyTrashed()->orderByDesc('deleted_at')->paginate();
        return view('admin.forms.trash', compact('forms'));
    }
    public function restore(Request $request, $id)
    {
        $form = Form::onlyTrashed()->findOrFail($id);
        $form->restore();
        return redirect()->route('dashboard.forms.trash')->with('success', 'تم استعادة الرسالة بنجاح');
    }
    public function forceDelete($id)
    {
        $form = Form::onlyTrashed()->findOrFail($id);
        $form->forceDelete();
        return redirect()->route('dashboard.forms.trash')->with('danger', 'تم حذف القسم بنجاح');
    }
}
