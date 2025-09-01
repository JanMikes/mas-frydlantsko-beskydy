<?php

declare(strict_types=1);

namespace MASFB\Web\Controller;

use MASFB\Web\Services\Strapi\StrapiContent;
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
        return $this->render('archiv_vyzev.html.twig', [
            'vyzvy' => $this->content->getVyzvy(null, true),
            'kategorie' => $this->content->getVyzvyKategorie(),
        ]);
    }
}
