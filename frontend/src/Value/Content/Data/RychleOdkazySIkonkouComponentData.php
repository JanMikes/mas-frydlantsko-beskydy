<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type IkonkaSOdkazemDataArray from IkonkaSOdkazemData
 * @phpstan-type RychleOdkazySIkonkouComponentDataArray array{
 *     Odkazy: list<IkonkaSOdkazemDataArray>,
 * }
 */
readonly final class RychleOdkazySIkonkouComponentData
{
    /**
     * @param list<IkonkaSOdkazemData> $Odkazy
     */
    public function __construct(
        public array $Odkazy,
    ) {}

    /**
     * @param RychleOdkazySIkonkouComponentDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $odkazy = [];
        foreach ($data['Odkazy'] as $odkazData) {
            $odkazy[] = IkonkaSOdkazemData::createFromStrapiResponse($odkazData);
        }

        return new self(
            Odkazy: $odkazy,
        );
    }
}
