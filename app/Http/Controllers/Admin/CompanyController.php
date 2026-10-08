<?php

/*
 * ASSUMPTIONS — adjust to match your app:
 * - Company::latestPayment() exists (payments.user_id = companies.user_id).
 * - Payment has a `subscriptionPlan()` belongsTo relation (via subscription_plan_id).
 * - Payment.status is 'success' | 'pending' | 'failed'.
 * - Subscription activation happens in the marked spot inside approvePayment().
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return view('admin.companies.index', [
            'companies' => Company::with(['latestPayment.subscriptionPlan'])
                ->withCount('jobs')
                ->latest()
                ->paginate(20),
        ]);
    }

    public function verify(Company $company)
    {
        $this->authorize('verify', $company);

        $company->update(['is_verified' => true]);

        return back()->with('success', 'Company verified.');
    }

    public function approvePayment(Company $company)
    {
        $this->authorize('verify', $company);

        $payment = $company->latestPayment;

        if (! $payment || $payment->status !== 'pending') {
            return back()->with('error', 'This company has no pending payment to approve.');
        }

        DB::transaction(function () use ($company, $payment) {
            $payment->update(['status' => 'success']);

            // Activate the subscription here, using your own columns, e.g.:
            // $company->user->update([
            //     'subscription_plan_id' => $payment->subscription_plan_id,
            //     'subscription_ends_at' => now()->addDays($payment->subscriptionPlan->duration_days),
            // ]);
        });

        return back()->with('success', 'Payment approved and subscription activated.');
    }
}
