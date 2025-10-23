<?php

declare(strict_types=1);

namespace MASFB\Web\Controller;

use MASFB\Web\Services\Strapi\StrapiContent;
use MASFB\Web\Value\Content\Data\TagData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArchivVyzevController extends AbstractController
{
    public function __construct(
        readonly private StrapiContent $content
    ) {}

    #[Route('/archiv-vyzev', name: 'archiv_vyzev')]
    public function __invoke(): Response
    {
        $vyzvy = $this->content->getVyzvy(null, true);

        /** @var array<TagData> $tags */
        $tags = [];
        /** @var array<string> $existingTags */
        $existingTags = [];

        foreach ($vyzvy as $vyzva) {
            foreach ($vyzva->Tagy as $tag) {
                if (!in_array($tag->slug, $existingTags, true)) {
                    $tags[] = $tag;
                    $existingTags[] = $tag->slug;
                }
            }
        }

        usort($tags, fn(TagData $a, TagData $b) => $a->slug <=> $b->slug);

        return $this->render('archiv_vyzev.html.twig', [
            'tags' => $tags,
            'vyzvy' => $vyzvy,
            'kategorie' => $this->content->getVyzvyKategorie(),
        ]);
    }
}
