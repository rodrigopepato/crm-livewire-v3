<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait HasSearch
{
    public function scopeSearch(Builder $query, ?string $search = null, ?array $columns = []): Builder
    {
        return $query->when($search, function (Builder $q) use ($search, $columns) {
            foreach ($columns as $column) {
                $q->orWhere(
                    DB::raw('lower(' . $column . ')'), /** @phpstan-ignore-line */
                    'like',
                    '%' . strtolower($search) . '%'
                );
            }
        });
    }
}
