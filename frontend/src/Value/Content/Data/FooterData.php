<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type OdkazSTextemDataArray from OdkazSTextemData
 * @phpstan-type FooterDataArray array{
 *     Odkazy_sluzby: array<OdkazSTextemDataArray>,
 *     Odkazy_vyzvy: array<OdkazSTextemDataArray>,
 *  }
 */
readonly final class FooterData
{
    /**
     * @param array<OdkazSTextemData> $OdkazySluzby
     * @param array<OdkazSTextemData> $OdkazyVyzvy
     */
    public function __construct(
        public array $OdkazySluzby,
        public array $OdkazyVyzvy,
    ) {}

    /**
     * @param FooterDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            OdkazySluzby: OdkazSTextemData::createManyFromStrapiResponse($data['Odkazy_sluzby']),
            OdkazyVyzvy: OdkazSTextemData::createManyFromStrapiResponse($data['Odkazy_vyzvy']),
        );
    }
}
