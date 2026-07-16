<?php

declare(strict_types=1);

namespace MailerMine\Support;

use JsonSerializable;
use OpenAPI\Client\Model\PaginationMeta;

/**
 * Pagination metadata extracted from list responses.
 */
final class Pagination implements JsonSerializable
{
    public function __construct(
        public readonly int $currentPage,
        public readonly int $perPage,
        public readonly int $total,
        public readonly int $lastPage,
    ) {}

    public static function fromMeta(?PaginationMeta $meta): ?self
    {
        if ($meta === null) {
            return null;
        }

        return new self(
            currentPage: (int) ($meta->getCurrentPage() ?? 1),
            perPage: (int) ($meta->getPerPage() ?? 15),
            total: (int) ($meta->getTotal() ?? 0),
            lastPage: (int) ($meta->getLastPage() ?? 1),
        );
    }

    /**
     * @param  array<string, mixed>  $meta
     */
    public static function fromArray(array $meta): self
    {
        return new self(
            currentPage: (int) ($meta['current_page'] ?? 1),
            perPage: (int) ($meta['per_page'] ?? 25),
            total: (int) ($meta['total'] ?? 0),
            lastPage: (int) ($meta['last_page'] ?? 1),
        );
    }

    public function hasMorePages(): bool
    {
        return $this->currentPage < $this->lastPage;
    }

    /**
     * @return array{current_page: int, per_page: int, total: int, last_page: int}
     */
    public function toArray(): array
    {
        return [
            'current_page' => $this->currentPage,
            'per_page' => $this->perPage,
            'total' => $this->total,
            'last_page' => $this->lastPage,
        ];
    }

    /**
     * @return array{current_page: int, per_page: int, total: int, last_page: int}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
