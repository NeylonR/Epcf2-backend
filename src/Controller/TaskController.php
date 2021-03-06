<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\TodoList;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    #[Route('/taskCreate/{id<\d+>}', name: 'app_task_create')]
    public function taskCreate(Request $request, EntityManagerInterface $em, TodoList $todoList): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $task->setTodoList($todoList);
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('app_list_detail', ['id' => $task->getTodoList()->getId()]);
        }
        return $this->render('index/taskCreate.html.twig', [
            'form' => $form->createView(),
            'list' => $todoList
        ]);
    }

    #[Route('/taskModify/{id<\d+>}', name: 'app_task_modify')]
    public function taskModify(Request $request, EntityManagerInterface $em, Task $task): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

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
    public function listDelete(TaskRepository $taskRepository, TodoList $todoList, EntityManagerInterface $em): Response
    {
        // $taskRepository->deleteDoneTask($todoList->getId());
        // la dql qui pose soucis

        $lists = $taskRepository->findBy(['todoList' => $todoList->getId(), 'todoState' => true]);
        foreach($lists as $task){
            $em->remove($task);
            $em->flush();
        }
        
        return $this->redirectToRoute('app_list_detail', ['id' => $todoList->getId()]);
    }
}
