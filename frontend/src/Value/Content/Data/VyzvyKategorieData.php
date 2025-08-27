<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type VyzvyKategorieDataArray array{
 *     Nazev: null|string,
 *     slug: null|string,
 * }
 */
readonly final class VyzvyKategorieData
{
    /** @use CanCreateManyFromStrapiResponse<VyzvyKategorieDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|string $Nazev,
        public null|string $slug,
    ) {
    }

    /**
     * @param VyzvyKategorieDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nazev: $data['Nazev'],
            slug: $data['slug'],
        );
    }
}
