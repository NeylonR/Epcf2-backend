<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\TodoList;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Repository\TodoListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    #[Route('/taskCreate/{id<\d+>}', name: 'app_task_create')]
    public function taskCreate(Request $request, EntityManagerInterface $em, TodoList $todoList, TodoListRepository $todoListRepository ): Response
    {
        // $todoList = $todoListRepository->findBy(['id' => ])
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        // dd($task);

        if($form->isSubmitted() && $form->isValid()){
            $task->setTodoList($todoList);
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('app_list_detail', ['id' => $task->getTodoList()->getId()]);
        }
        return $this->render('index/taskCreate.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/taskModify/{id<\d+>}', name: 'app_task_modify')]
    public function taskModify(Request $request, EntityManagerInterface $em, Task $task): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        // dd($task->getTodoList()->getId());

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('app_list_detail', ['id' => $task->getTodoList()->getId()]);
        }
        return $this->render('index/taskCreate.html.twig', [
            'form' => $form->createView(),
            'task' => $task
        ]);
    }

    #[Route('/taskDelete/{id<\d+>}', name: 'app_task_delete_done')]
    public function listDelete(TaskRepository $taskRepository, TodoList $todoList): Response
    {
        $taskRepository->deleteDoneTask($todoList->getId());
        $taskRepository->findBy(['todoList' =>])
        // dd($lists);
        return $this->redirectToRoute('app_index');
    }
}
