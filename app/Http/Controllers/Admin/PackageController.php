<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
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
        $packages = Package::filter($request->query())
            ->orderBy($orderBy, $direction)
            ->paginate($itemsPerPage); // Return collection object work like array

        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $package = new Package();
        return view('admin.packages.create', compact('package'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        // $clean_data فيها البيانات التي فحصت بنجاح فقط
        $clean_data = $request->validate(Package::rules(), [
            'unique' => 'هذا  (:attribute) موجود بالفعل!',
            'required' => 'هذا الحقل مطلوب',
        ]);
        $data = $request->except('advantages');
        $package = Package::create($data);

        foreach ($request->advantages as $key => $value) {
            if ($value != null) {
                Advantage::create([
                    'package_id' => $package->id,
                    'text' => $value,
                    'updated_by' => auth()->user()->id,
                ]);
            }
        }

        return Redirect()->route('dashboard.packages.index')->with('success', 'تم انشاء باقة جديدة بنجاح'); // redirect will return object that have method route
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        try {
            $package = Package::findOrFail($package->id);
        } catch (\Throwable $th) {
            //abort(404);
            return redirect()->route('admin.packages.index')->with('info', 'هذه الباقة غير موجودة');
        }
        // return $package->advantages;
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $request->validate(Package::rules($package->id));
        try {
            $package = Package::findOrFail($package->id);
        } catch (\Throwable $th) {
            //abort(404);
            return redirect()->route('admin.packages.index')->with('info', 'هذه الباقة غير موجودة');
        }

        $advantages = Advantage::where('package_id', $package->id)->get();

        if ($advantages->isEmpty()) {
            foreach ($request->advantages as $index => $value) {
                // if ($value['text'] != null) {
                Advantage::create([
                    'package_id' => $package->id,
                    'text' => $value['text'] ?? '',
                    'updated_by' => auth()->user()->id,
                ]);
                // }
            }
        } else {
            foreach ($request->advantages as $index => $value) {
                // if ($value['text'] != null) {
                $advantageToUpdate = $advantages[$index];
                $advantageToUpdate->package_id = $package->id;
                $advantageToUpdate->text = $value['text'] ?? '';
                $advantageToUpdate->updated_by = auth()->user()->id;
                $advantageToUpdate->save();
                // }
            }
        }

        //$category->fill($request->all())->save();
        $package->update($request->all());
        return Redirect()->route('dashboard.packages.index')->with('success', 'تم تحديث الباقة بنجاح!'); // redirect will return object that have method route
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        // way 1
        $package = Package::findOrFail($package->id);
        $package->delete();
        return Redirect()->route('dashboard.packages.index')->with('danger', 'تم حذف الباقة بنجاح!');
    }

    public function trash()
    {
        $packages = Package::onlyTrashed()->orderByDesc('deleted_at')->paginate();
        return view('admin.packages.trash', compact('packages'));
    }
    public function restore(Request $request, $id)
    {
        $package = Package::onlyTrashed()->findOrFail($id);
        $package->restore();
        return redirect()->route('dashboard.packages.trash')->with('success', 'تم استعادة الباقة بنجاح');
    }
    public function forceDelete($id)
    {
        $package = Package::onlyTrashed()->findOrFail($id);
        $package->forceDelete();
        return redirect()->route('dashboard.packages.trash')->with('danger', 'تم حذف الباقة بنجاح');
    }
}
