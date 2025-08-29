<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type OdkazDataArray from OdkazData
 * @phpstan-type NadpisComponentDataArray array{
 *     Nadpis: string,
 *     Typ: string,
 *     Kotva: null|string,
 *     Styl: null|string,
 *     Odkaz: null|OdkazDataArray,
 * }
 */
readonly final class NadpisComponentData
{
    public function __construct(
        public string $Nadpis,
        public string $Typ,
        public null|string $Kotva,
        public null|string $Styl,
        public null|OdkazData $Odkaz,
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
            Odkaz: $data['Odkaz'] !== null ? OdkazData::createFromStrapiResponse($data['Odkaz']) : null,
        );
    }
}
