<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserStatsController extends Controller
{
    /**
     * Tampilkan statistik pengguna.
     */
    public function index()
    {
        return view('admin.stats.users');
    }
}
