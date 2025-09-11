<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type PaginationMetaArray array{
 *     start: int,
 *     limit: int,
 *     total: int,
 * }
 */
readonly final class PaginationMeta
{
    public function __construct(
        public int $start,
        public int $limit,
        public int $total,
    ) {
    }

    /**
     * @param PaginationMetaArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            start: $data['start'],
            limit: $data['limit'],
            total: $data['total'],
        );
    }

    public function getCurrentPage(): int
    {
        return (int) floor($this->start / $this->limit) + 1;
    }

    public function getTotalPages(): int
    {
        return (int) ceil($this->total / $this->limit);
    }

    public function hasNextPage(): bool
    {
        return $this->getCurrentPage() < $this->getTotalPages();
    }

    public function hasPreviousPage(): bool
    {
        return $this->getCurrentPage() > 1;
    }
}