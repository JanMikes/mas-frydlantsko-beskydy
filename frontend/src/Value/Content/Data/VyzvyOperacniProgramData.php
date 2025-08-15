<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type VyzvyOperacniProgramDataArray array{
 *     Nazev: null|string,
 * }
 */
readonly final class VyzvyOperacniProgramData
{
    /** @use CanCreateManyFromStrapiResponse<VyzvyOperacniProgramDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|string $Nazev,
    ) {
    }

    /**
     * @param VyzvyOperacniProgramDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nazev: $data['Nazev'],
        );
    }
}
