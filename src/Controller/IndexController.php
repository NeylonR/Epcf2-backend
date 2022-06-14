<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Entity\TodoList;
use App\Form\TodoListType;
use App\Repository\TodoListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(TodoListRepository $todoListRepository): Response
    {
        $lists = $todoListRepository->findAll();
        // dd($lists);
        return $this->render('index/index.html.twig', [
            'lists' => $lists
        ]);
    }
}
