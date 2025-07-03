<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchHistoryController extends Controller
{
    // Menampilkan histori pencarian milik user yang login
    public function index()
    {
        $histories = Auth::user()->searchHistories()
            ->orderBy('searched_at', 'desc')
            ->get();

        return response()->json($histories);
    }

    // Menambahkan histori pencarian baru
    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        $history = Auth::user()->searchHistories()->create([
            'keyword' => $request->keyword,
            'searched_at' => now(),
        ]);

        return response()->json($history, 201);
    }

    // Menghapus 1 histori berdasarkan ID (hanya milik user)
    public function destroy($id)
    {
        $history = Auth::user()->searchHistories()
            ->where('id', $id)
            ->firstOrFail();

        $history->delete();

        return response()->json(['message' => 'History deleted']);
    }

    // Menghapus semua histori milik user yang login
    public function clear()
    {
        Auth::user()->searchHistories()->delete();

        return response()->json(['message' => 'All history cleared']);
    }
}
