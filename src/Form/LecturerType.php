<?php

namespace App\Form;

use App\Entity\Lecturer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LecturerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lecturerName', TextType::class, [ 
                'label' => 'Lecturer Name',
            ])
            ->add('lecturerEmail', EmailType::class, [ 
                'label' => 'Lecturer Email',
            ])
            ->add('lecturerSpecialisation', TextType::class, [ 
                'label' => 'Specialisation',
            ])
            ->add('lecturerGender', ChoiceType::class, [ 
                'label' => 'Gender',
                'choices'  => [
                    'Male' => 'male',
                    'Female' => 'female',
                ],
                'expanded' => true,
                'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lecturer::class,
        ]);
    }
}
