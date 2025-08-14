<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type ProjektyOperacniProgramDataArray array{
 *     Nazev: null|string,
 * }
 */
readonly final class ProjektyOperacniProgramData
{
    /** @use CanCreateManyFromStrapiResponse<ProjektyOperacniProgramDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|string $Nazev,
    ) {
    }

    /**
     * @param ProjektyOperacniProgramDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nazev: $data['Nazev'],
        );
    }
}