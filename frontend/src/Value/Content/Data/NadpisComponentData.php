<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type NadpisComponentDataArray array{
 *     Nadpis: string,
 *     Typ: string,
 *     Kotva: null|string,
 *     Styl: null|string,
 * }
 */
readonly final class NadpisComponentData
{
    public function __construct(
        public string $Nadpis,
        public string $Typ,
        public null|string $Kotva,
        public null|string $Styl,
    ) {}

    /**
     * @param NadpisComponentDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nadpis: $data['Nadpis'],
            Typ: $data['Typ'],
            Kotva: $data['Kotva'],
            Styl: $data['Styl'],
        );
    }
}
