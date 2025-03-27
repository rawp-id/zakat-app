<?php

namespace App\Http\Controllers;

use App\Models\Zakat;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $zakat = Zakat::all();
        $approve_zakat = 0;
        $cancel_zakat = 0;
        foreach ($zakat as $item) {
            if ($item->status == 'approved') {
                $approve_zakat += $item->amount;
            } else {
                $cancel_zakat += $item->amount;
            }
        }

        // dd($count_zakat);
        return view('dashboard', compact('approve_zakat', 'cancel_zakat'));
    }
}
