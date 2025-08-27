<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type RadekTabulkyDataArray array{
 *     Sloupec_1: null|string,
 *     Sloupec_2: null|string,
 *     Sloupec_3: null|string,
 *     Sloupec_4: null|string,
 *     Sloupec_5: null|string,
 *     Sloupec_6: null|string,
 * }
 */
readonly final class RadekTabulkyData
{
    /** @use CanCreateManyFromStrapiResponse<RadekTabulkyDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|string $Sloupec1,
        public null|string $Sloupec2,
        public null|string $Sloupec3,
        public null|string $Sloupec4,
        public null|string $Sloupec5,
        public null|string $Sloupec6,
    ) {
    }

    /**
     * @param RadekTabulkyDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Sloupec1: $data['Sloupec_1'],
            Sloupec2: $data['Sloupec_2'],
            Sloupec3: $data['Sloupec_3'],
            Sloupec4: $data['Sloupec_4'],
            Sloupec5: $data['Sloupec_5'],
            Sloupec6: $data['Sloupec_6'],
        );
    }
}
