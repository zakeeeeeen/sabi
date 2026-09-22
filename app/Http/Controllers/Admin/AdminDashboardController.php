<?php

namespace App\Http\Controllers\Admin;

use App\Models\SpendingItem;
use App\Models\StudentSubmission;
use App\Models\User;

class AdminDashboardController extends AdminController
{
    public function index()
    {
        $totalStudents = User::where('is_admin', 0)->count();
        $totalSubmissions = StudentSubmission::count();
        $totalIdeBisnis = StudentSubmission::where('step_key', 'ide_bisnis')->count();
        $totalRencanaKeuangan = StudentSubmission::where('step_key', 'hitung_modal')->count();
        $totalPengembanganBisnis = StudentSubmission::where('step_key', 'studi_kasus_investasi')->count();
        $totalSpendingItems = SpendingItem::count();

        $recentSubmissions = StudentSubmission::with('user')
            ->latest()
            ->take(8)
            ->get();

        $recentStudents = User::where('is_admin', 0)
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', [
            'totalStudents' => $totalStudents,
            'totalSubmissions' => $totalSubmissions,
            'totalIdeBisnis' => $totalIdeBisnis,
            'totalRencanaKeuangan' => $totalRencanaKeuangan,
            'totalPengembanganBisnis' => $totalPengembanganBisnis,
            'totalSpendingItems' => $totalSpendingItems,
            'recentSubmissions' => $recentSubmissions,
            'recentStudents' => $recentStudents,
        ]);
    }
}
