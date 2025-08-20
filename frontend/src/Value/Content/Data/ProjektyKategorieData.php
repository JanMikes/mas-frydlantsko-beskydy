<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type ProjektyKategorieDataArray array{
 *     Nazev: null|string,
 *     slug: null|string,
 * }
 */
readonly final class ProjektyKategorieData
{
    /** @use CanCreateManyFromStrapiResponse<ProjektyKategorieDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|string $Nazev,
        public null|string $slug,
    ) {
    }

    /**
     * @param ProjektyKategorieDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nazev: $data['Nazev'],
            slug: $data['slug'],
        );
    }
}
