<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', '=', 'published');
    }

    public function scopeSearch(Builder $query, ?string $search = null): Builder
    {
        return $query->when(
            $search,
            fn (Builder $q) => $q->where('question', 'like', "%{$search}%")
        );
    }
}
