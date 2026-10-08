<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function __construct(protected SubscriptionService $subscriptions)
    {
    }

    // If your existing index() has extra filters/stats, merge them in here.
    public function index(Request $request)
    {
        $payments = Payment::with(['user', 'plan'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderByRaw("CASE status WHEN 'pending' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    /** Streams the private proof image to admins only. */
    public function proof(Payment $payment)
    {
        abort_unless(
            $payment->payment_proof && Storage::disk('local')->exists($payment->payment_proof),
            404
        );

        return Storage::disk('local')->response($payment->payment_proof);
    }

    public function approve(Request $request, Payment $payment)
    {
        $approved = DB::transaction(function () use ($request, $payment) {
            $locked = Payment::with(['user', 'plan'])->whereKey($payment->getKey())->lockForUpdate()->firstOrFail();

            if ($locked->status !== 'pending') {
                return false;
            }

            $locked->forceFill([
                'status' => 'approved',
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
                'rejection_reason' => null,
            ])->save();

            // Activates the subscription. If this throws, the approval rolls back.
            $this->subscriptions->subscribe($locked->user, $locked->plan);

            return true;
        });

        return back()->with(
            $approved ? 'success' : 'error',
            $approved ? 'Payment approved and subscription activated.' : 'This payment has already been reviewed.'
        );
    }

    public function reject(Request $request, Payment $payment)
    {
        $data = $request->validate(['rejection_reason' => ['nullable', 'string', 'max:500']]);

        $updated = Payment::whereKey($payment->getKey())->where('status', 'pending')->update([
            'status' => 'rejected',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'rejection_reason' => $data['rejection_reason'] ?? null,
        ]);

        return back()->with(
            $updated ? 'success' : 'error',
            $updated ? 'Payment rejected.' : 'This payment has already been reviewed.'
        );
    }
}
