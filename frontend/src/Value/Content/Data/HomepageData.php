<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type SlideDataArray from SlideData
 * @phpstan-import-type KartaSArgumentyDataArray from KartaSArgumentyData
 * @phpstan-type HomepageDataArray array{
 *     Slider: array<SlideDataArray>,
 *     Karty: array<KartaSArgumentyDataArray>,
 *  }
 */
readonly final class HomepageData
{
    /**
     * @param array<SlideData> $Slider
     * @param array<KartaSArgumentyData> $Karty
     */
    public function __construct(
        public array $Slider,
        public array $Karty,
    ) {}

    /**
     * @param HomepageDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Slider: SlideData::createManyFromStrapiResponse($data['Slider']),
            Karty: KartaSArgumentyData::createManyFromStrapiResponse($data['Karty']),
        );
    }
}
