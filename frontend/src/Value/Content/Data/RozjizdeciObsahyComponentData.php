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

        // Sort tags: numeric descending (2025, 2024...), then alphabetic ascending (A, B...)
        usort($tags, static function (TagData $a, TagData $b): int {
            $aIsNumeric = is_numeric($a->slug);
            $bIsNumeric = is_numeric($b->slug);

            // Both numeric - sort descending (newest first)
            if ($aIsNumeric && $bIsNumeric) {
                return (int) $b->slug <=> (int) $a->slug;
            }

            // Both non-numeric - sort alphabetically ascending
            if (!$aIsNumeric && !$bIsNumeric) {
                return $a->slug <=> $b->slug;
            }

            // Mixed - numeric comes before non-numeric
            return $aIsNumeric ? -1 : 1;
        });

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
