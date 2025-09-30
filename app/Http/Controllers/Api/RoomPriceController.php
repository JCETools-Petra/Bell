<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\PriceOverride;
use Carbon\Carbon;

class RoomPriceController extends Controller
{
    /**
     * Mengambil harga dinamis untuk semua kamar pada satu tanggal spesifik.
     */
    public function getPricesOnDate(Request $request)
    {
        $request->validate(['date' => 'required|date_format:d-m-Y']);

        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $rooms = Room::where('is_available', true)->get();
        $prices = [];

        foreach ($rooms as $room) {
            $override = PriceOverride::where('room_id', $room->id)
                                     ->where('date', $date)
                                     ->first();
            
            $prices[$room->id] = [
                'price' => $override ? $override->price : $room->price,
                'is_special' => (bool)$override
            ];
        }

        return response()->json($prices);
    }

    /**
     * FUNGSI BARU: Mengambil harga harian HANYA UNTUK KAMAR SUPERIOR untuk sebulan penuh.
     */
    public function getPricesForMonth(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|between:2020,2030',
            'month' => 'required|integer|between:1,12',
        ]);

        $year = $request->year;
        $month = $request->month;

        // Mencari kamar 'Superior' secara spesifik
        $baseRoom = Room::where('name', 'Superior')->where('is_available', true)->first();
        
        // Jika tidak ada kamar 'Superior', jangan tampilkan harga apapun
        if (!$baseRoom) {
            return response()->json([]);
        }
        $basePrice = $baseRoom->price;

        // Ambil semua harga khusus (override) untuk kamar Superior pada bulan yang diminta
        $overrides = PriceOverride::whereYear('date', $year)
                                  ->whereMonth('date', $month)
                                  ->where('room_id', $baseRoom->id)
                                  ->pluck('price', 'date');

        $prices = [];
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day)->format('Y-m-d');
            $isSpecial = $overrides->has($date);
            
            $prices[$date] = [
                'price' => $isSpecial ? $overrides[$date] : $basePrice,
                'is_special' => $isSpecial
            ];
        }

        return response()->json($prices);
    }
}