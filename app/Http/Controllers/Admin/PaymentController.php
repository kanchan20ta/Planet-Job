<?php

/*
 * ASSUMPTIONS — please adjust to match your app:
 * - `Payment` has: user_id (payer), amount, status ('success'|'pending'|'failed'),
 *   payment_method (nullable string), transaction_id (nullable string), created_at.
 * - `Payment` belongsTo `User` via a `user()` relation. If payments are instead tied to
 *   an employer's subscription, add/rename a `subscriptionPlan()` relation and swap the
 *   `with([...])` call and the Blade columns below accordingly.
 * - Reuses the same status values already queried in Admin\DashboardController
 *   ('success' for revenue, so 'pending' and 'failed' are the other two states).
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with('user')
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status'));
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $totals = [
            'total_revenue' => Payment::where('status', 'success')->sum('amount'),
            'total_count' => Payment::count(),
            'pending_count' => Payment::where('status', 'pending')->count(),
            'failed_count' => Payment::where('status', 'failed')->count(),
        ];

        return view('admin.payments.index', compact('payments', 'totals'));
    }
}
