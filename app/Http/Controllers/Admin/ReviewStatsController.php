<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewStatsController extends Controller
{
    /**
     * Tampilkan statistik review.
     */
    public function index()
    {
        return view('admin.stats.reviews');
    }
}
