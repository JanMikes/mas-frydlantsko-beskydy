<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type BunkaTabulkyDataArray from BunkaTabulkyData
 * @phpstan-type RadekTabulkyDataArray array{
 *     Sloupec_1: null|BunkaTabulkyDataArray,
 *     Sloupec_2: null|BunkaTabulkyDataArray,
 *     Sloupec_3: null|BunkaTabulkyDataArray,
 *     Sloupec_4: null|BunkaTabulkyDataArray,
 * }
 */
readonly final class RadekTabulkyData
{
    /** @use CanCreateManyFromStrapiResponse<RadekTabulkyDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|BunkaTabulkyData $Sloupec1,
        public null|BunkaTabulkyData $Sloupec2,
        public null|BunkaTabulkyData $Sloupec3,
        public null|BunkaTabulkyData $Sloupec4,
    ) {
    }

    /**
     * @param RadekTabulkyDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Sloupec1: $data['Sloupec_1'] !== null ? BunkaTabulkyData::createFromStrapiResponse($data['Sloupec_1']) : null,
            Sloupec2: $data['Sloupec_2'] !== null ? BunkaTabulkyData::createFromStrapiResponse($data['Sloupec_2']) : null,
            Sloupec3: $data['Sloupec_3'] !== null ? BunkaTabulkyData::createFromStrapiResponse($data['Sloupec_3']) : null,
            Sloupec4: $data['Sloupec_4'] !== null ? BunkaTabulkyData::createFromStrapiResponse($data['Sloupec_4']) : null,
        );
    }
}
