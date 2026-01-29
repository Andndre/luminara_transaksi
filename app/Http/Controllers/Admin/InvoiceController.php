<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Authorization Check
        $user = auth()->user();
        if ($user->division !== 'super_admin' && $booking->business_unit !== $user->division) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        // Generate Invoice Number (Example: INV/2026/01/001)
        $invNumber = 'INV/' . $booking->created_at->format('Y/m') . '/' . str_pad($booking->id, 4, '0', STR_PAD_LEFT);

        return view('admin.invoices.print', compact('booking', 'invNumber'));
    }
}