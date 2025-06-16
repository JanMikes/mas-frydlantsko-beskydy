<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use MASFB\Web\Services\Strapi\StrapiLinkHelper;
use MASFB\Web\Value\Content\Data\OdkazData;

#[AsTwigComponent]
final class Odkaz
{
    public null|OdkazData $data = null;

    public function __construct(
        readonly private StrapiLinkHelper $strapiLinkHelper,
    ) {
    }

    public function getLink(): string
    {
        assert($this->data !== null);

        if ($this->data->sekceSlug !== null) {
            return $this->strapiLinkHelper->getLinkForSlug($this->data->sekceSlug);
        }

        return $this->data->url ?? '#';
    }
}
