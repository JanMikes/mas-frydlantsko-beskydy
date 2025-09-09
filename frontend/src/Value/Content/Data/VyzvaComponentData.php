<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type VyzvyKategorieDataArray from VyzvyKategorieData
 * @phpstan-type VyzvaComponentDataArray array{
 *     Obory: array<VyzvyKategorieDataArray>
 * }
 */
readonly final class VyzvaComponentData
{
    /**
     * @param array<VyzvyKategorieData> $Kategorie
     */
    public function __construct(
        public array $Kategorie,
    ) {
    }

    /**
     * @param array{} $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Kategorie: VyzvyKategorieData::createManyFromStrapiResponse($data['Obory']),
        );
    }
}
