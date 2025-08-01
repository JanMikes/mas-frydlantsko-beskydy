<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type HistorieDataArray from HistorieData
 * @phpstan-type HistorieComponentDataArray array{
 *     Historie: array<HistorieDataArray>,
 * }
 */
readonly final class HistorieComponentData
{
    public function __construct(
        /** @var array<HistorieData> */
        public array $items,
    ) {
    }

    /**
     * @param HistorieComponentDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            items: HistorieData::createManyFromStrapiResponse($data['Historie']),
        );
    }
}
