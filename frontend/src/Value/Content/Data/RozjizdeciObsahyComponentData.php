<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type RozjizdeciObsahDataArray from RozjizdeciObsahData
 */
readonly final class RozjizdeciObsahyComponentData
{
    /**
     * @var array<TagData>
     */
    public array $Tagy;

    /**
     * @param array<RozjizdeciObsahData> $Polozky
     */
    public function __construct(
        public array $Polozky,
        public string $Styl,
    ) {
        $tags = [];
        $existingTags = [];

        foreach ($this->Polozky as $polozka) {
            foreach ($polozka->Tagy as $tag) {
                if (!in_array($tag->slug, $existingTags, true)) {
                    $tags[] = $tag;
                    $existingTags[] = $tag->slug;
                }
            }
        }

        $this->Tagy = $tags;
    }

    /**
     * @param array{
     *     Polozky: array<RozjizdeciObsahDataArray>,
     *     Styl: null|string,
     * } $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Polozky: RozjizdeciObsahData::createManyFromStrapiResponse($data['Polozky']),
            Styl: $data['Styl'] ?? 'Styl 1',
        );
    }
}
