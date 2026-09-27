<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct(protected SubscriptionService $subscriptions)
    {
    }

    public function index()
    {
        return view('employer.subscription.index', [
            'plans' => SubscriptionPlan::where('role', 'employer')->where('is_active', true)->orderBy('price')->get(),
            'current' => $this->subscriptions->activeSubscription(Auth::user()),
        ]);
    }

    /**
     * NOTE: this activates the plan immediately for demo purposes.
     * In production, redirect to the payment gateway (eSewa/Khalti/Stripe)
     * first and only call subscribe() from the payment success webhook,
     * after creating a matching Payment record.
     */
    public function store(SubscriptionPlan $plan)
    {
        $this->subscriptions->subscribe(Auth::user(), $plan);

        return redirect()->route('employer.dashboard')->with('success', "Subscribed to the {$plan->name} plan.");
    }
}
