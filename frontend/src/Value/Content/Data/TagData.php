<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type TagDataArray array{
 *     slug: string,
 *     Tag: string,
 *     Zobrazovat_v_aktualitach: null|bool,
 * }
 */
readonly final class TagData
{
    /** @use CanCreateManyFromStrapiResponse<TagDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public string $slug,
        public string $Tag,
        public bool $Aktuality,
    ) {
    }

    /**
     * @param TagDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            slug: $data['slug'],
            Tag: $data['Tag'],
            Aktuality: $data['Zobrazovat_v_aktualitach'] ?? true,
        );
    }
}
