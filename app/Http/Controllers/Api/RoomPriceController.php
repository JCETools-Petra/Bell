<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\PriceOverride;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

        $user = Auth::user();
        $isEligibleForDiscount = Auth::check() && in_array($user->role, ['admin', 'affiliate']);

        foreach ($rooms as $room) {
            $override = PriceOverride::where('room_id', $room->id)
                                     ->where('date', $date)
                                     ->first();
            
            $basePrice = $override ? $override->price : $room->price;
            $finalPrice = $this->calculateDiscountedPrice($basePrice, $room->discount_percentage, $isEligibleForDiscount);

            $prices[$room->id] = [
                'price' => $finalPrice,
                'is_special' => (bool)$override
            ];
        }

        return response()->json($prices);
    }

    public function getPricesForMonth(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|between:2020,2030',
            'month' => 'required|integer|between:1,12',
            'room_id' => 'nullable|exists:rooms,id', // Validasi room_id opsional
        ]);

        $year = $request->year;
        $month = $request->month;

        // Jika room_id dikirim, gunakan itu. Jika tidak, ambil kamar termurah sebagai default.
        if ($request->has('room_id') && $request->room_id) {
            $baseRoom = Room::find($request->room_id);
        } else {
            $baseRoom = Room::where('is_available', true)->orderBy('price', 'asc')->first();
        }
        
        if (!$baseRoom) {
            return response()->json([]);
        }

        $basePrice = $baseRoom->price;
        $discountPercentage = $baseRoom->discount_percentage;

        $overrides = PriceOverride::whereYear('date', $year)
                                  ->whereMonth('date', $month)
                                  ->where('room_id', $baseRoom->id)
                                  ->pluck('price', 'date');

        $prices = [];
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        
        $isEligibleForDiscount = Auth::check() && in_array(Auth::user()->role, ['admin', 'affiliate']);

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day)->format('Y-m-d');
            $isSpecial = $overrides->has($date);
            
            $currentBasePrice = $isSpecial ? $overrides[$date] : $basePrice;
            $finalPrice = $this->calculateDiscountedPrice($currentBasePrice, $discountPercentage, $isEligibleForDiscount);

            $prices[$date] = [
                'price' => $finalPrice,
                'is_special' => $isSpecial
            ];
        }

        return response()->json($prices);
    }

    /**
     * Helper method to calculate discounted price.
     */
    private function calculateDiscountedPrice($price, $discountPercentage, $isEligible)
    {
        if ($isEligible && $discountPercentage > 0) {
            $discountAmount = $price * ($discountPercentage / 100);
            return $price - $discountAmount;
        }
        return $price;
    }
}