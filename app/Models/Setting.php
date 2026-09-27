<?php

/*
 * ASSUMPTIONS — please adjust to match your app:
 * - Backed by a `settings` table with columns: id, key (string, unique), value (string,
 *   nullable), timestamps. If you already have a migration/table for settings with
 *   different column names, update $fillable (and any casts) to match.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];
}
