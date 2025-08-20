<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type KategorieKalendareDataArray array{
 *     id: int,
 *     Nazev: string,
 *     slug: string,
 *  }
 */
readonly final class KategorieKalendareData
{
    /** @use CanCreateManyFromStrapiResponse<KategorieKalendareDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public int $id,
        public string $Nazev,
        public string $slug,
    ) {
    }

    /**
     * @param KategorieKalendareDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['id'],
            $data['Nazev'],
            $data['slug'],
        );
    }
}
