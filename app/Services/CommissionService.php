<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\Booking;
use App\Models\Commission;

class CommissionService
{
    /**
     * Calculate commission amount based on booking amount and affiliate commission rate
     */
    public function calculateCommissionAmount(float $bookingAmount, float $commissionRate): float
    {
        return $bookingAmount * ($commissionRate / 100);
    }

    /**
     * Create a commission record for a booking
     */
    public function createCommission(Affiliate $affiliate, Booking $booking, ?string $notes = null): Commission
    {
        $commissionAmount = $this->calculateCommissionAmount(
            $booking->total_price,
            $affiliate->commission_rate
        );

        return Commission::create([
            'affiliate_id' => $affiliate->id,
            'booking_id' => $booking->id,
            'commission_amount' => $commissionAmount,
            'rate' => $affiliate->commission_rate,
            'status' => 'unpaid',
            'notes' => $notes,
        ]);
    }

    /**
     * Get unpaid commission amount for an affiliate
     */
    public function getUnpaidAmount(Affiliate $affiliate): float
    {
        return $affiliate->commissions()
            ->where('status', 'unpaid')
            ->sum('commission_amount');
    }

    /**
     * Mark all unpaid commissions as paid for an affiliate
     */
    public function markAsPaid(Affiliate $affiliate, ?int $month = null): int
    {
        $query = Commission::where('affiliate_id', $affiliate->id)
            ->where('status', 'unpaid');

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        return $query->update(['status' => 'paid']);
    }

    /**
     * Get commissions for an affiliate filtered by status and month
     */
    public function getCommissions(Affiliate $affiliate, string $status = 'unpaid', ?int $month = null)
    {
        $query = Commission::where('affiliate_id', $affiliate->id)
            ->where('status', $status)
            ->with('booking');

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        return $query->get();
    }
}
