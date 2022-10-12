<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WebPages extends Model
{
    use HasFactory, DatabaseTransactions;

    /**
     * Get the university that owns the web pages.
     */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'university_web_pages';

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
}
