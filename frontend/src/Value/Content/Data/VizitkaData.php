<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type ClovekDataArray from ClovekData
 * @phpstan-import-type TelefonDataArray from TelefonData
 * @phpstan-type VizitkaDataArray array{
 *     Adresa: null|string,
 *     Odkaz_na_mapu: null|string,
 *     Odkaz: null|string,
 *     Nadpis_oteviraci_doby: null|string,
 *     Oteviraci_doba: null|string,
 *     Email: null|string,
 *     Poznamka: null|string,
 *     Telefony: array<TelefonDataArray>,
 *     lides: array<ClovekDataArray>,
 * }
 */
readonly final class VizitkaData
{
    /** @use CanCreateManyFromStrapiResponse<VizitkaDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|string $Adresa,
        public null|string $OdkazNaMapu,
        public null|string $Odkaz,
        public null|string $OteviraciDoba,
        public null|string $NadpisOteviraciDoby,
        public null|string $Email,
        public null|string $Poznamka,
        /** @var array<ClovekData> */
        public array $lides,
        /** @var array<TelefonData> */
        public array $Telefony,
    ) {}

    /**
     * @param VizitkaDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Adresa: $data['Adresa'],
            OdkazNaMapu: $data['Odkaz_na_mapu'],
            Odkaz: $data['Odkaz'],
            OteviraciDoba: $data['Oteviraci_doba'],
            Email: $data['Email'],
            Poznamka: $data['Poznamka'],
            NadpisOteviraciDoby: $data['Nadpis_oteviraci_doby'],
            lides: ClovekData::createManyFromStrapiResponse($data['lides']),
            Telefony: TelefonData::createManyFromStrapiResponse($data['Telefony']),
        );
    }
}
