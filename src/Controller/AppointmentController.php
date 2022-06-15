<?php

namespace App\Controller;

use Faker\Factory;
use App\Data\FilterData;
use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Form\AppointmentSearchType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AppointmentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppointmentController extends AbstractController
{
    #[Route('/appointment', name: 'app_appointment')]
    public function index(Request $request, PaginatorInterface $paginator,AppointmentRepository $appointmentRepository): Response
    {
        $lists = $appointmentRepository->findAll();

        $filter = new FilterData();
        $form = $this->createForm(AppointmentSearchType::class, $filter);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            // if($filter->priority !== null && $filter->priority > 3 || $filter->priority < 1){
            //     return $this->render('appointment/index.html.twig', [
            //         'lists' => $lists,
            //         'form' => $form->createView(),
            //         'error' => 'Priority must be higher than 0 and lower or equal to 4'
            //     ]);
            // }

            $result = $appointmentRepository->findAppointment($filter);
            $result = $paginator->paginate($result, $request->query->getInt('page', 1), 15);
            return $this->render('appointment/index.html.twig', [
                'lists' => $result,
                'form'=> $form->createView()
            ]);
        }
        $lists = $paginator->paginate($lists, $request->query->getInt('page', 1), 15);
        return $this->render('appointment/index.html.twig', [
            'lists' => $lists,
            'form'=> $form->createView()
        ]);
    }

    #[Route('/appointmentCreate', name: 'app_appointment_create')]
    public function appointmentCreate(Request $request, EntityManagerInterface $em): Response
    {
        $appointment = new Appointment();
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($form->getViewData()->getPriority() > 3 || $form->getViewData()->getPriority() < 1){
                return $this->render('appointment/appointmentCreate.html.twig', [
                    'form' => $form->createView(),
                    'error' => 'Priority must be higher than 0 and lower or equal to 4'
                ]);
            }

            $em->persist($appointment);
            $em->flush();

            return $this->redirectToRoute('app_appointment');
        }
        return $this->render('appointment/appointmentCreate.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/appointmentGeneration', name: 'app_appointment_generate')]
    public function appointGeneration(EntityManagerInterface $em, AppointmentRepository $appointmentRepository)
    {
        $db = $appointmentRepository->findAll();
        foreach($db as $appoint){
            $appointmentRepository->remove($appoint);
        }
        $faker = Factory::create();
        for($i = 0; $i<5; $i++){
            $appointment = new Appointment();
            $appointment->setName($faker->name);
            $appointment->setPlace($faker->city);
            $appointment->setPriority($faker->numberBetween(1, 3));
            $appointment->setBeginDate($faker->dateTimeBetween('-1 years', 'now'));
            $appointment->setEndDate($faker->dateTimeBetween('+50days', '+1 years'));
            $em->persist($appointment);
        }
        $em->flush();
        return $this->redirectToRoute('app_appointment');
    }
}
