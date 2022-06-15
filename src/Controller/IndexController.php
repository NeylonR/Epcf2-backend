<?php

namespace App\Controller;

use App\Repository\TodoListRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(TodoListRepository $todoListRepository): Response
    {
        $lists = $todoListRepository->findAll();

        return $this->render('index/index.html.twig', [
            'lists' => $lists
        ]);
    }
}
