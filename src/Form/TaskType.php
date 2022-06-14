<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\TodoList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            // ->add('todoState', CheckboxType::class, [
            //     'label' => 'Tick if task is done',
            //     'required' => false,
            // ])
            ->add('todoState', ChoiceType::class, [
                'choices'  => [
                    'Todo' => false,
                    'Done' => true,

                ]
            ])
            // ->add('todoList', EntityType::class, [
            //     'class' => TodoList::class,
            //     'choice_label' => 'name'
            // ])
            ->add('Create', SubmitType::class, [
                'attr' => ['class' => 'button']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
