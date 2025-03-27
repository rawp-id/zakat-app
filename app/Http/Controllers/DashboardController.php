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

        // Statistik zakat approved per hari
        $zakat_per_day = Zakat::where('status', 'approved')
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $labels = $zakat_per_day->pluck('date')->toArray();
        $data = $zakat_per_day->pluck('total')->toArray();

        // dd($count_zakat);
        return view('dashboard', compact('approve_zakat', 'cancel_zakat', 'labels', 'data'));
    }
}
