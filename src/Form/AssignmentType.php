<?php

namespace App\Form;

use App\Entity\Assignment;
use App\Entity\Course;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssignmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('assignmentName', TextType::class, [
                'label' => 'Assignment Name',
            ])
            ->add('dueDate', DateType::class, [
                'label' => 'Due Date',
                'widget' => 'single_text',
            ])
            ->add('status', TextType::class, [
                'label' => 'Status',
            ])
            ->add('course', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'course_name',
                'label' => 'Select Course',
                'placeholder' => 'Choose a course',
                'mapped' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Assignment::class,
        ]);
    }
}
