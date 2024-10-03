<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Lecturer;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('courseName', TextType::class, [
                'label' => 'Course Name',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('credits', IntegerType::class, [
                'label' => 'Credits',
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Start Date',
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'End Date',
            ])
            ->add('instructor', EntityType::class, [
                'class' => Lecturer::class,
                'choice_label' => 'lecturerName',
                'label' => 'Instructor',
            ])
            ->add('students', ChoiceType::class, [
                'choices' => $options['students'],
                'choice_label' => function (Student $student) {
                    return $student->getStudentName();
                },
                'expanded' => true,
                'multiple' => true,
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
            'students' => [],
        ]);
    }
}


