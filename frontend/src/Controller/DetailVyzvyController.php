<?php

declare(strict_types=1);

namespace MASFB\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use MASFB\Web\Services\Strapi\StrapiContent;

final class DetailVyzvyController extends AbstractController
{
    public function __construct(
        readonly private StrapiContent $content
    ) {}


    #[Route('/vyzvy/{slug}', name: 'detail_vyzvy')]
    public function __invoke(string $slug): Response
    {
        try {
            return $this->render('detail_vyzvy.html.twig',[
                'vyzva' => $this->content->getVyzva($slug),
            ]);
        } catch (ClientException) {
            throw $this->createNotFoundException();
        }
    }
}
