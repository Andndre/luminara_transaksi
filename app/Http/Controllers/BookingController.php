<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BlockedDate;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // Public: Landing Page
    public function landing()
    {
        return view('landing');
    }

    // Public: Booking Page
    public function create()
    {
        return view('booking');
    }

    // Public: Check Availability JSON
    public function availability(Request $request)
    {
        $month = $request->query('month', date('Y-m')); // YYYY-MM
        $start = $month . '-01';
        $end = date('Y-m-t', strtotime($start));

        // Get blocked dates
        $blocked = BlockedDate::whereBetween('date', [$start, $end])
            ->get()
            ->map(function ($item) {
                return $item->date->format('Y-m-d');
            })
            ->toArray();

        // Get booking counts per date
        $bookings = Booking::select('event_date', DB::raw('count(*) as total'))
            ->whereBetween('event_date', [$start, $end])
            ->where('status', '!=', Booking::STATUS_DIBATALKAN)
            ->groupBy('event_date')
            ->pluck('total', 'event_date')
            ->toArray();

        $results = [];

        $datesOfInterest = array_unique(array_merge($blocked, array_keys($bookings)));

        foreach ($datesOfInterest as $date) {
            $isBlocked = in_array($date, $blocked);
            $count = $bookings[$date] ?? 0;

            $results[] = [
                'date' => $date,
                'booking_count' => (int)$count,
                'max_booking' => 4,
                'is_blocked' => $isBlocked
            ];
        }

        return response()->json($results);
    }

    // Public: Store Booking
    public function store(Request $request)
    {
        $request->validate([
            'customer_phone' => 'required|string',
            'price_total' => 'required|numeric',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'event_maps_link' => 'nullable|url',
        ]);

        $date = $request->event_date;

        if (BlockedDate::where('date', $date)->exists()) {
            return back()->withErrors(['event_date' => 'Tanggal ini tidak tersedia (Blocked).']);
        }

        $count = Booking::where('event_date', $date)
            ->where('status', '!=', Booking::STATUS_DIBATALKAN)
            ->count();

        if ($count >= 4) {
            return back()->withErrors(['event_date' => 'Tanggal ini sudah penuh (Max 4 slot).']);
        }

        // Handle File Upload & Status
        $proofPath = null;
        $initialStatus = Booking::STATUS_PENDING;
        $waPaymentMsg = "Saya belum melakukan pembayaran DP.";

        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            $initialStatus = Booking::STATUS_DP_DIBAYAR;
            $waPaymentMsg = "Bukti pembayaran DP sudah diupload ke sistem.";
        }

        $booking = Booking::create([
            'package_name' => $request->package_name,
            'package_type' => $request->package_type,
            'duration_hours' => $request->duration_hours,
            'price_total' => $request->price_total,
            'payment_type' => $proofPath ? 'DP_TRANSFER' : 'NONE',
            'payment_proof' => $proofPath,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'event_location' => $request->event_location,
            'event_maps_link' => $request->event_maps_link,
            'event_type' => $request->event_type ?? '-',
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'notes' => $request->notes,
            'status' => $initialStatus,
        ]);

        $mapsInfo = $booking->event_maps_link ? "\nMaps: {$booking->event_maps_link}" : "";

        $message = "Halo Admin Luminara,\n\n"
            . "Booking Baru:\n"
            . "Nama: {$booking->customer_name}\n"
            . "WhatsApp: {$booking->customer_phone}\n"
            . "Acara: {$booking->event_type}\n"
            . "Paket: {$booking->package_name}\n"
            . "Tanggal: " . \Carbon\Carbon::parse($booking->event_date)->translatedFormat('d F Y') . "\n"
            . "Jam: " . \Carbon\Carbon::parse($booking->event_time)->format('H:i') . " - " . \Carbon\Carbon::parse($booking->event_time)->addHours($booking->duration_hours)->format('H:i') . " WITA\n"
            . "Durasi: {$booking->duration_hours} jam\n"
            . "Lokasi: {$booking->event_location}"
            . $mapsInfo . "\n\n"
            . $waPaymentMsg;

        $encodedMessage = urlencode($message);
        $adminPhone = '6287788986136';
        $waUrl = "https://wa.me/{$adminPhone}?text={$encodedMessage}";

        return redirect()->away($waUrl);
    }

    // Admin: Dashboard Overview
    public function dashboard()
    {
        // Monthly Stats
        $startOfMonth = now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = now()->endOfMonth()->format('Y-m-d');

        $totalBookings = Booking::whereBetween('event_date', [$startOfMonth, $endOfMonth])
            ->where('status', '!=', Booking::STATUS_DIBATALKAN)
            ->count();

        $revenue = Booking::whereBetween('event_date', [$startOfMonth, $endOfMonth])
            ->whereIn('status', [Booking::STATUS_LUNAS, Booking::STATUS_DP_DIBAYAR])
            ->sum('price_total');

        $pendingCount = Booking::where('status', Booking::STATUS_PENDING)->count();

        // Upcoming Events (Next 7 Days)
        $upcomingEvents = Booking::where('event_date', '>=', now()->format('Y-m-d'))
            ->where('event_date', '<=', now()->addDays(7)->format('Y-m-d'))
            ->where('status', '!=', Booking::STATUS_DIBATALKAN)
            ->orderBy('event_date', 'asc')
            ->orderBy('event_time', 'asc')
            ->get();

        return view('admin.dashboard', compact('totalBookings', 'revenue', 'pendingCount', 'upcomingEvents'));
    }

    // Admin: List Bookings
    public function adminIndex(Request $request)
    {
        $sort = $request->query('sort', 'event_date');
        $direction = $request->query('direction', 'desc');

        // Allow only specific columns for sorting to prevent SQL injection
        if (!in_array($sort, ['event_date', 'created_at'])) {
            $sort = 'event_date';
        }

        $bookings = Booking::orderBy($sort, $direction)->paginate(10)->withQueryString();
        
        return view('admin.bookings.index', compact('bookings'));
    }

    // Admin: Update Status
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $request->validate([
            'status' => 'required|in:PENDING,DP_DIBAYAR,LUNAS,DIBATALKAN'
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Status updated.');
    }

    // Admin: Calendar & Block Dates
    public function calendarIndex()
    {
        $blockedDates = BlockedDate::orderBy('date', 'desc')->get();
        return view('admin.calendar.index', compact('blockedDates'));
    }

    public function blockDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date|unique:blocked_dates,date',
            'reason' => 'nullable|string'
        ]);

        BlockedDate::create([
            'date' => $request->date,
            'reason' => $request->reason
        ]);

        return back()->with('success', 'Tanggal berhasil diblokir.');
    }

    public function unblockDate($id)
    {
        BlockedDate::findOrFail($id)->delete();
        return back()->with('success', 'Tanggal kembali dibuka.');
    }
}
