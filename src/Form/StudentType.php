<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('studentName', TextType::class, [ 
                'label' => 'Student Name',
            ])
            ->add('studentEmail', EmailType::class, [ 
                'label' => 'Student Email',
            ])
            ->add('studentGender', ChoiceType::class, [
                'label' => 'Gender',
                'choices'  => [
                    'Male' => 'male',
                    'Female' => 'female',
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('dateOfBirth', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date of Birth',
            ])
            ->add('registrationDate', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Registration Date',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
