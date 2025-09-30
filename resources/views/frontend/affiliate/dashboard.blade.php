@extends('layouts.frontend')

@section('seo_title', 'Affiliate Dashboard')

@section('content')
<div class="page-content-wrapper">
    <div class="container my-5">
        
        {{-- ========================================================== --}}
        {{-- PERUBAHAN ADA DI BLOK DI BAWAH INI --}}
        {{-- ========================================================== --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-5">Affiliate Dashboard</h1>
            <a href="{{ route('affiliate.bookings.create') }}" class="btn btn-primary">Create New Booking</a>
        </div>
        {{-- ========================================================== --}}

        {{-- Affiliate Link --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Your Unique Referral Link</h5>
                <p class="text-muted">Bagikan link ini untuk mulai mendapatkan komisi.</p>
                <div class="input-group">
                    <input type="text" class="form-control" id="referralLink" value="{{ route('home') }}/?ref={{ $affiliate->referral_code }}" readonly>
                    <button class="btn btn-outline-secondary" type="button" onclick="copyLink()">Copy</button>
                </div>
            </div>
        </div>

        {{-- Statistics --}}
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Total Clicks</h6>
                        <p class="card-text display-4">{{ $totalClicks }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Successful Bookings</h6>
                        <p class="card-text display-4">{{ $totalBookings }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Unpaid Commissions</h6>
                        <p class="card-text display-4">Rp {{ number_format($totalCommissions, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Commission History --}}
        <h3 class="mt-5 mb-4">Commission History</h3>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($commissions as $commission)
                            <tr>
                                <td>#{{ $commission->booking_id }}</td>
                                <td>Rp {{ number_format($commission->amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $commission->status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($commission->status) }}
                                    </span>
                                </td>
                                <td>{{ $commission->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">No commissions yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $commissions->links() }}
        </div>
    </div>
</div>

<script>
    function copyLink() {
        var copyText = document.getElementById("referralLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
        alert("Link copied to clipboard: " + copyText.value);
    }
</script>
@endsection