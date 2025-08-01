<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type BunkaTabulkyDataArray array{
 *     Hodnota: string,
 *     Styl: string,
 * }
 */
readonly final class BunkaTabulkyData
{
    public function __construct(
        public string $Hodnota,
        public string $Styl,
    ) {
    }

    /**
     * @param BunkaTabulkyDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Hodnota: $data['Hodnota'],
            Styl: $data['Styl'],
        );
    }
}
