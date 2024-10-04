<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 *
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function add(Course $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Course $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Course[] Returns an array of Course objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Course
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

// src/Controller/CourseController.php

public function removeStudentFromCourse(Request $request, Course $course, Student $student): Response
{
    $studentCourseDetail = $this->getDoctrine()->getRepository(StudentCourseDetails::class)
        ->findOneBy(['course' => $course, 'student' => $student]);

    if ($studentCourseDetail) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($studentCourseDetail);
        $entityManager->flush();
    }

    return $this->redirectToRoute('course_edit', ['id' => $course->getId()]);
}

public function addStudentToCourse(Request $request, Course $course, Student $student): Response
{
    $entityManager = $this->getDoctrine()->getManager();

    $studentCourseDetail = new StudentCourseDetails();
    $studentCourseDetail->setCourse($course);
    $studentCourseDetail->setStudent($student);

    $entityManager->persist($studentCourseDetail);
    $entityManager->flush();

    return $this->redirectToRoute('course_edit', ['id' => $course->getId()]);
}

}
