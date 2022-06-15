<?php

namespace App\Controller;

use App\Entity\TodoList;
use App\Form\TodoListType;
use App\Form\TodoListEditType;
use App\Repository\TodoListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TodoListController extends AbstractController
{
    
    #[Route('/list/{id<\d+>}', name: 'app_list_detail')]
    public function listDetail(TodoList $list): Response
    {
        return $this->render('index/listDetail.html.twig', [
            'list' => $list
        ]);
    }

    #[Route('/listCreate', name: 'app_list_create')]
    public function listCreate(Request $request, EntityManagerInterface $em, ): Response
    {
        $list = new TodoList();
        $form = $this->createForm(TodoListType::class, $list);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($list);
            $em->flush();

            return $this->redirectToRoute('app_list_detail', ['id' => $list->getId()]);
        }
        return $this->render('index/listCreate.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/listModify/{id<\d+>}', name: 'app_list_modify')]
    public function listModify(Request $request, EntityManagerInterface $em, TodoList $todoList): Response
    {
        $form = $this->createForm(TodoListEditType::class, $todoList);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($todoList);
            $em->flush();

            return $this->redirectToRoute('app_list_detail', ['id' => $todoList->getId()]);
        }
        return $this->render('index/listCreate.html.twig', [
            'form' => $form->createView(),
            'list' => $todoList
        ]);
    }

    #[Route('/listDelete/{id<\d+>}', name: 'app_list_delete')]
    public function listDelete(TodoListRepository $todoListRepository, TodoList $list): Response
    {
        $todoListRepository->remove($list);

        return $this->redirectToRoute('app_index');
    }
}
