<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type NadpisComponentDataArray array{
 *     Nadpis: string,
 *     Typ: string,
 * }
 */
readonly final class NadpisComponentData
{
    public function __construct(
        public string $Nadpis,
        public string $Typ,
    ) {}

    /**
     * @param NadpisComponentDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['Nadpis'],
            $data['Typ'],
        );
    }
}
