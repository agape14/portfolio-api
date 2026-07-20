<?php

declare(strict_types=1);

namespace App\Models\Concerns;

trait RewritesStorageUrls
{
    protected function rewriteStorageUrl(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        if (preg_match('#(/storage/.+)$#', $value, $matches) !== 1) {
            return $value;
        }

        return rtrim((string) config('app.url'), '/') . $matches[1];
    }
}
