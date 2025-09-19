<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type VyzvyKategorieDataArray from VyzvyKategorieData
 * @phpstan-type ProjektyComponentDataArray array{
 *     Kategorie: null|VyzvyKategorieDataArray
 * }
 */
readonly final class ProjektyComponentData
{
    public function __construct(
        public null|VyzvyKategorieData $kategorie,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            kategorie: $data['Kategorie'] !== null ? VyzvyKategorieData::createFromStrapiResponse($data['Kategorie']) : null,
        );
    }
}
