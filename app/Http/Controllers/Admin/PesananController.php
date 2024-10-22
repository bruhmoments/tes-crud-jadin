<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with('detailPesanan')->get();

        return view('admin.pesanan.index', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $statusPesanan = ['pending', 'diproses', 'dikirim', 'selesai'];
        $indexCurrentStatus = array_search($pesanan->status, $statusPesanan);

        if ($indexCurrentStatus !== false && $indexCurrentStatus < count($statusPesanan) - 1) {
            $pesanan->status = $statusPesanan[$indexCurrentStatus + 1];
            $pesanan->save();

            Log::info('Send email to '.$pesanan->email_pembeli.': status pesanan anda sekarang adalah '.$pesanan->status);
            return redirect()->back()->with('success', 'Status pesanan diubah.');
        }

        return redirect()->back()->with('error', 'Status pesanan gagal terubah.');
    }
}
