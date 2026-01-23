<?php

namespace App\Http\Controllers;

use App\Models\LetterIncoming;
use App\Models\LetterOutgoing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';

        // Tanggal sekarang
        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;

        // ===============================
        // Total surat masuk bulan ini
        // ===============================
        $lettermonth = LetterIncoming::whereMonth('letterdate', $currentMonth)
                        ->whereYear('letterdate', $currentYear)
                        ->count();

        // ===============================
        // Total surat keluar bulan ini
        // ===============================
        $letterm = LetterOutgoing::whereMonth('letterdate', $currentMonth)
                        ->whereYear('letterdate', $currentYear)
                        ->count();

        // ===============================
        // Total surat masuk tahun ini
        // ===============================
        $letteryear = LetterIncoming::whereYear('letterdate', $currentYear)
                        ->count();

        // ===============================
        // Total surat keluar tahun ini
        // ===============================
        $lettery = LetterOutgoing::whereYear('letterdate', $currentYear)
                        ->count();

        // ===============================
        // Data grafik 6 bulan pertama
        // ===============================
        $monthlyCounts = [];

        for ($i = 1; $i <= 6; $i++) {
            $monthlyCounts[] = LetterIncoming::whereMonth('letterdate', $i)
                                ->whereYear('letterdate', $currentYear)
                                ->count();
        }

        $monthlyJson = json_encode($monthlyCounts);

        // ===============================
        // Pending surat keluar
        // ===============================
        $pendingCount = LetterOutgoing::where(function ($query) {
                                $query->whereNull('is_tindak')
                                      ->orWhere('is_tindak', 0);
                            })
                            ->where('is_realis', 1)
                            ->count();

        // ===============================
        // Surat sudah ditindak
        // ===============================
        $letterstatus = LetterOutgoing::where('is_tindak', 1)->count();

        return view('dashboard.index', compact(
            'title',
            'lettermonth',
            'letterm',
            'letteryear',
            'lettery',
            'monthlyJson',
            'pendingCount',
            'letterstatus'
        ));
    }
}