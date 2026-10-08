<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (! Schema::hasColumn('payments', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            }
            if (! Schema::hasColumn('payments', 'subscription_plan_id')) {
                $table->foreignId('subscription_plan_id')->nullable()->constrained()->nullOnDelete();
            }
            if (! Schema::hasColumn('payments', 'amount')) {
                $table->decimal('amount', 10, 2)->default(0);
            }
            if (! Schema::hasColumn('payments', 'payment_method')) {
                $table->string('payment_method')->nullable();
            }
            if (! Schema::hasColumn('payments', 'status')) {
                $table->string('status')->default('pending')->index();
            }
            if (! Schema::hasColumn('payments', 'payment_proof')) {
                $table->string('payment_proof')->nullable();
            }
            if (! Schema::hasColumn('payments', 'reviewed_by')) {
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('payments', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable();
            }
            if (! Schema::hasColumn('payments', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Intentionally left empty: columns may have pre-existed this migration.
    }
};
