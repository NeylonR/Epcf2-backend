<?php

namespace App\Form;

use App\Data\FilterData;
use App\Entity\Appointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AppointmentSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('place', TextType::class, [
                'required' => false,
            ])
            ->add('priority', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 1,
                    'max' => 3,
                ],
            ])
            ->add('beginDate', DateTimeType::class, [
                'required' => false,
                'label' => 'Start the',
                'widget' => 'single_text'
            ])
            ->add('endDate', DateTimeType::class, [
                'required' => false,
                'label' => 'End the',
                'widget' => 'single_text'
            ])
            ->add('Search', SubmitType::class, [
                'attr' => ['class' => 'button']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FilterData::class,
        ]);
    }
}
