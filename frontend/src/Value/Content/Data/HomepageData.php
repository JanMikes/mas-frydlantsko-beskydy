<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type SlideDataArray from SlideData
 * @phpstan-import-type RozjizdeciObsahTextDataArray from RozjizdeciObsahTextData
 * @phpstan-type HomepageDataArray array{
 *     Slider: array<SlideDataArray>,
 *     Zakladni_informace: array<RozjizdeciObsahTextDataArray>,
 *  }
 */
readonly final class HomepageData
{
    /**
     * @param array<SlideData> $Slider
     * @param array<RozjizdeciObsahTextData> $ZakladniInformace
     */
    public function __construct(
        public array $Slider,
        public array $ZakladniInformace,
    ) {}

    /**
     * @param HomepageDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Slider: SlideData::createManyFromStrapiResponse($data['Slider']),
            ZakladniInformace: RozjizdeciObsahTextData::createManyFromStrapiResponse($data['Zakladni_informace']),
        );
    }
}
