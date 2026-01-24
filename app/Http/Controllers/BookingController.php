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
            ->pluck('date')
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
            'package_name' => 'required|string',
            'package_type' => 'required|string',
            'duration_hours' => 'required|integer|min:1',
            'event_date' => 'required|date|after_or_equal:today',
            'event_time' => 'required',
            'event_location' => 'required|string',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'price_total' => 'required|numeric',
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

        $booking = Booking::create([
            'package_name' => $request->package_name,
            'package_type' => $request->package_type,
            'duration_hours' => $request->duration_hours,
            'price_total' => $request->price_total,
            'payment_type' => 'NONE',
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'event_location' => $request->event_location,
            'event_type' => $request->event_type ?? '-',
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'notes' => $request->notes,
            'status' => Booking::STATUS_PENDING,
        ]);

        $message = "Halo Admin Luminara 👋\n\n"
            . "Booking baru:\n"
            . "Nama: {$booking->customer_name}\n"
            . "Acara: {$booking->event_type}\n"
            . "Paket: {$booking->package_name}\n"
            . "Tanggal: " . $booking->event_date->format('Y-m-d') . "\n"
            . "Jam: " . \Carbon\Carbon::parse($booking->event_time)->format('H:i') . " WITA\n"
            . "Durasi: {$booking->duration_hours} jam\n"
            . "Lokasi: {$booking->event_location}";

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
    public function adminIndex()
    {
        $bookings = Booking::orderBy('event_date', 'desc')->paginate(10);
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
