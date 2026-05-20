<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LiveComponentController extends AbstractController
{
    #[Route('/live/component', name: 'app_live_component')]
    public function index(): Response
    {
        return $this->render('live_component/index.html.twig', [
            'controller_name' => 'LiveComponentController',
        ]);
    }
}
