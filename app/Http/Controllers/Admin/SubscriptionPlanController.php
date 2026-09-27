<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        return view('admin.subscription-plans.index', ['plans' => SubscriptionPlan::orderBy('price')->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('subscription_plans', 'name')->where('role', 'employer'),
            ],
            'type' => ['required', 'string', 'in:latest,featured'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'job_post_limit' => ['required', 'integer', 'min:0'],
        ]);

        $plan = new SubscriptionPlan();
        $plan->name = $validated['name'];
        $plan->type = $validated['type'];
        $plan->price = $validated['price'];
        $plan->duration_days = $validated['duration_days'];
        $plan->job_post_limit = $validated['job_post_limit'];
        $plan->slug = $this->uniqueSlug($validated['name']);
        $plan->role = 'employer';
        $plan->featured_job_limit = 0;
        $plan->cv_access = false;
        $plan->is_active = true;
        $plan->save();

        return back()->with('success', 'Plan created.');
    }

    /**
     * Build a deterministic slug for the plan name, only falling back to a
     * numeric suffix if that exact slug is somehow already taken (e.g. a
     * previously soft-deleted or renamed plan) — never a random one, so
     * re-submitting the same name can't silently create a duplicate.
     */
    protected function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;

        while (SubscriptionPlan::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('subscription_plans', 'name')
                    ->where('role', 'employer')
                    ->ignore($subscriptionPlan->id),
            ],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'job_post_limit' => ['required', 'integer', 'min:0'],
            'featured_job_limit' => [
                $subscriptionPlan->type === 'featured' ? 'required' : 'nullable',
                'integer', 'min:0',
            ],
        ]);

        $subscriptionPlan->update([
            ...$validated,
            'featured_job_limit' => $validated['featured_job_limit'] ?? $subscriptionPlan->featured_job_limit,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Plan updated.');
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();

        return back()->with('success', 'Plan deleted.');
    }
}
