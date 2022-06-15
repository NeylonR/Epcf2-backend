<?php

namespace App\Form;

use App\Entity\Appointment;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('place')
            ->add('priority', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 3,
                ],
            ])
            ->add('beginDate', DateTimeType::class, [
                'date_label' => 'Starts On',
                'widget' => 'single_text'
            ])
            ->add('endDate', DateTimeType::class, [
                'date_label' => 'Starts On',
                'widget' => 'single_text'
            ])
            // ->add('endDate') 
            ->add('Create', SubmitType::class, [
                'attr' => ['class' => 'button']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
