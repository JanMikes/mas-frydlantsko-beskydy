<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type BocniPanelComponentDataArray array{
 *      bocni_panel: null|array{komponenty: array<array{__component: string}>},
 *  }
 */
readonly final class BocniPanelComponentData
{
    /**
     * @param array<Component> $Komponenty
     */
    public function __construct(
        public array $Komponenty,
    ) {
    }

    /**
     * @param BocniPanelComponentDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $components = [];

        foreach ($data['bocni_panel']['komponenty'] ?? [] as $componentInfo) {
            $components[] = SekceData::createComponent($componentInfo);
        }

        return new self(
            Komponenty: $components,
        );
    }
}
