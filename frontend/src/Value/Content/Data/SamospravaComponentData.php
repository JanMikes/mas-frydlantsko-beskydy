<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type ClovekSamospravyDataArray from ClovekSamospravyData
 * @phpstan-type SamospravaComponentDataArray array{
 *     Nadpis: null|string,
 *     Lide: array<ClovekSamospravyDataArray>,
 * }
 */
readonly final class SamospravaComponentData
{
    /**
     * @param array<ClovekSamospravyData> $lide
     */
    public function __construct(
        public null|string $Nadpis,
        public array $lide,
    ) {}

    /**
     * @param SamospravaComponentDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nadpis: $data['Nadpis'],
            lide: ClovekSamospravyData::createManyFromStrapiResponse($data['Lide']),
        );
    }
}
