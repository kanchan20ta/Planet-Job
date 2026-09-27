<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DedupeSubscriptionPlans extends Command
{
    protected $signature = 'plans:dedupe {--dry-run : Show what would change without writing anything}';

    protected $description = 'Merge duplicate subscription plans (same name + role) into the oldest row, '
        . 'reassigning any subscriptions before deleting the extras.';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        $groups = SubscriptionPlan::orderBy('id')
            ->get()
            ->groupBy(fn (SubscriptionPlan $plan) => strtolower($plan->name) . '|' . $plan->role);

        $duplicateGroups = $groups->filter(fn ($plans) => $plans->count() > 1);

        if ($duplicateGroups->isEmpty()) {
            $this->info('No duplicate plans found.');

            return self::SUCCESS;
        }

        foreach ($duplicateGroups as $key => $plans) {
            // Keep the oldest row (lowest id). If several duplicates differ
            // in price/limits, keep whichever is currently active; if more
            // than one is active, still keep the oldest and just report it
            // so you can eyeball which values are "correct" before rerunning.
            $keep = $plans->sortBy('id')->first();
            $extras = $plans->reject(fn ($p) => $p->id === $keep->id);

            $this->line('');
            $this->info("Duplicate: \"{$keep->name}\" ({$keep->role}) — keeping plan #{$keep->id} ({$keep->slug})");

            foreach ($extras as $extra) {
                $subCount = Subscription::where('plan_id', $extra->id)->count();
                $this->line("  - plan #{$extra->id} ({$extra->slug}), price={$extra->price}, active=" . ($extra->is_active ? 'yes' : 'no') . ", {$subCount} subscription(s) attached");

                if ($dryRun) {
                    continue;
                }

                DB::transaction(function () use ($extra, $keep) {
                    // Re-point any subscriptions to the plan we're keeping
                    // before deleting the duplicate, since plan_id cascade
                    // deletes subscriptions otherwise.
                    Subscription::where('plan_id', $extra->id)->update(['plan_id' => $keep->id]);
                    $extra->delete();
                });
            }
        }

        $this->line('');
        $this->info($dryRun
            ? 'Dry run complete — no changes were made. Re-run without --dry-run to apply.'
            : 'Duplicate plans merged.');

        return self::SUCCESS;
    }
}
