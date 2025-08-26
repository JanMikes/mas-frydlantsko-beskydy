<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

use MASFB\Web\Value\Content\Data\FooterData;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use MASFB\Web\Services\Strapi\StrapiContent;

#[AsTwigComponent]
readonly final class Footer
{
    public function __construct(
        private StrapiContent $content,
    ) {
    }

    public function getData(): null|FooterData
    {
        try {
            return $this->content->getFooterData();
        } catch (ClientException) {
            return null;
        }
    }
}
