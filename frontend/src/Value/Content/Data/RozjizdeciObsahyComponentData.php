<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type RozjizdeciObsahDataArray from RozjizdeciObsahData
 */
readonly final class RozjizdeciObsahyComponentData
{
    /**
     * @param array<RozjizdeciObsahData> $Polozky
     */
    public function __construct(
        public array $Polozky,
    ) {}

    /**
     * @param array{
     *     Polozky: array<RozjizdeciObsahDataArray>,
     * } $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Polozky: RozjizdeciObsahData::createManyFromStrapiResponse($data['Polozky']),
        );
    }
}