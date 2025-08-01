<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type MapaDataArray array{
 *      URL: string,
 *  }
 */
readonly final class MapaComponentData
{
    public function __construct(
        public string $URL,
    ) {}

    /**
     * @param MapaDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            URL: $data['URL'],
        );
    }
}
