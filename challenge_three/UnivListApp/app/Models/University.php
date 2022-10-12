<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'universities';

    protected $fillable = ['state-province', 'alpha_two_code', 'country', 'name'];

    use HasFactory;

    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }

    public function webPages(): HasMany
    {
        return $this->hasMany(WebPages::class);
    }
}
