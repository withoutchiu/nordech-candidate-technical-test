<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domain extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'university_domains';

    protected $fillable = ['domain'];


    /**
     * Get the university that owns the domain.
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
}
