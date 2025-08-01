<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type FaqDataArray from FaqData
 */
readonly final class FaqComponentData
{
    /**
     * @param array<FaqData> $items
     */
    public function __construct(
        public array $items,
    ) {}

    /**
     * @param array{
     *     FAQ: array<FaqDataArray>,
     * } $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            items: FaqData::createManyFromStrapiResponse($data['FAQ']),
        );
    }
}
