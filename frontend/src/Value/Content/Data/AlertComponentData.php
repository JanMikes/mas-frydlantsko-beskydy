<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type AlertDataArray array{
 *     Text: null|string,
 * }
 */
readonly final class AlertComponentData
{
    public function __construct(
        public null|string $Text,
    ) {}

    /**
     * @param AlertDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Text: $data['Text'],
        );
    }
}
