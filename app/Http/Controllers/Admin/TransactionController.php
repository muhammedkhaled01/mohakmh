<?php

namespace App\Http\Controllers\Admin;

use App\Models\InternationalTransactions;
use App\Models\LocalTransactions;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Profile;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
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
        $transactions = Transaction::with(['user'])->filter($request->query())
            ->orderBy($orderBy, $direction)
            ->paginate($itemsPerPage); // Return collection object work like array
        // return $transactions;

        return view('admin.transactions.index', compact('transactions'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $transaction)
    {
        // way 1
        $transaction = Transaction::findOrFail($transaction->id);

        $transaction->delete();

        return Redirect()->route('dashboard.transactions.index')->with('danger', 'تم حذف المعاملة بنجاح!');
    }

    public function trash()
    {
        $transactions = Transaction::onlyTrashed()->orderByDesc('deleted_at')->paginate();
        return view('admin.transactions.trash', compact('transactions'));
    }

    public function restore(Request $request, $id)
    {
        $transaction = Transaction::onlyTrashed()->findOrFail($id);
        $transaction->restore();

        return redirect()->route('dashboard.transactions.trash')->with('success', 'تم استعادة المعاملة بنجاح');
    }

    public function forceDelete($id)
    {
        $transaction = User::onlyTrashed()->findOrFail($id);

        $transaction->forceDelete();

        return redirect()->route('dashboard.transactions.trash')->with('danger', 'تم حذف المعاملة بنجاح');
    }

    public function localTransaction()
    {
        $transactions = LocalTransactions::all();
        return view("admin.transactions.local.index", compact("transactions"));
    }

    public function createLocalTransaction()
    {
        return view("admin.transactions.local.create");
    }

    public function saveLocalTransaction(Request $request)
    {
        //
//        $request->validate([
//            'name' => 'required',
//            'bank-transferred' => 'required',
//            'image_path' => 'required|mimes:jpg,png,jped',
//        ]);

        $newImageName = uniqid() . "-" . "imageTransactions" . "." . $request->image->extension();
        $request->image->move(public_path("images/transactions"), $newImageName);

        $transactions = LocalTransactions::all();

        $transactions = new LocalTransactions();
        $transactions->price = $request->input('price') + $request->input('tax');
        $transactions->name = $request->input('name');
        $transactions->bank_transferred = $request->input('bank_transferred');
        $transactions->image = $newImageName;

        $transactions->status = 'pending';
//        dd($transactions);
        $transactions->save();
        Session::flash('flash_message', 'قيد التحقق.');
        return redirect()->back();
    }

    public function showLocalTransactions($id)
    {
        $transactions = LocalTransactions::findOrFail($id);
        $statuses  = ['pending' , 'paid'];
        return view("admin.transactions.local.show" , compact("statuses"))->with("transactions", $transactions);
    }

    public function updateLocalTransactions(Request $request, $id)
    {
        $transactions = LocalTransactions::findOrFail($id);
        $transactions->status = $request->input("status");
        $transactions->update();
        return back()->with('success', 'تم تعديل المعاملة بنجاح!');
    }

    public function destroyLocalTransactions(string $id)
    {
        // way 1

        $delete = LocalTransactions::findOrFail($id);
        $delete->delete();

        return Redirect()->back()->with('danger', 'تم حذف المعاملة بنجاح!');
    }

    public function internationalTransaction()
    {
        $transactions = InternationalTransactions::all();
        return view("admin.transactions.international.index", compact("transactions"));
    }

    public function destroyInternationalTransactions(string $id)
    {
        $delete = InternationalTransactions::findOrFail($id);
        $delete->delete();

        return Redirect()->back()->with('danger', 'تم حذف المعاملة بنجاح!');
    }
}
