<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type ProjektyObecDataArray array{
 *     Nazev: null|string,
 * }
 */
readonly final class ProjektyObecData
{
    /** @use CanCreateManyFromStrapiResponse<ProjektyObecDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|string $Nazev,
    ) {
    }

    /**
     * @param ProjektyObecDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nazev: $data['Nazev'],
        );
    }
}