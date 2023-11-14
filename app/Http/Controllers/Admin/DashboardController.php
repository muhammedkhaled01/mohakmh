<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $catrgories = Category::count();
        $books = Book::count();
        $allusers = 0;
        $active_users = 0; // عملاء فعالين
        $clients = 0; // جميع العملاء
        $subscripe_clients = 0; // عملاء مشتركين

        foreach ($users as $user) {
            $allusers++;
            if ($user->role == 'user') {
                $clients++;
                if ($user->status == 'active') {
                    $active_users++;
                }
                if ($user->package_id !== null) {
                    $subscripe_clients++;
                }
            }
        }
        // return [$users, $catrgories, $books, $active_users, $clients, $subscripe_clients];
        return view('admin.index', compact(['allusers', 'catrgories', 'books', 'active_users', 'clients', 'subscripe_clients']));
    }
}
