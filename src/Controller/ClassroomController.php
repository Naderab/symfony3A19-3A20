<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Classroom::class);
        $classrooms=$repo->findAll();
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
            'classrooms'=>$classrooms
        ]);
    }
    // #[Route('/deleteClassroom/{id}',name: 'classroom_delete')]
    // public function deleteClassroom($id,ClassroomRepository $repo,ManagerRegistry $doctrine){
    //     $classroom = $repo->find($id);
    //     $entitymanager = $doctrine->getManager();
    //     $entitymanager->remove($classroom);
    //     $entitymanager->flush();
    //     return $this->redirectToRoute('app_classroom');
    // }

    #[Route('/deleteClassroom/{id}',name: 'classroom_delete')]
    public function deleteClassroom($id,ClassroomRepository $repo){
        $classroom = $repo->find($id);
        $repo->remove($classroom,true);
        return $this->redirectToRoute('app_classroom');
    }
    // #[Route('/addClassroom',name: 'classroom_add')]
    // public function addClassroom(ClassroomRepository $repo){
    //     $classroom = new Classroom();
    //     $classroom->setUsername('3A21');
    //     $classroom->setEmail('3A21@esprit.tn');
    //     $repo->save($classroom,true);
    //     return $this->redirectToRoute('app_classroom');
    // }
    #[Route('/addClassroom',name: 'classroom_add')]
    public function addClassroom(ClassroomRepository $repo,ManagerRegistry $doctrine){
        $classroom = new Classroom();
        $classroom->setUsername('3A21');
        $classroom->setEmail('3A21@esprit.tn');
        $entitymanager=$doctrine->getManager();
        $entitymanager->persist($classroom);
        $entitymanager->flush();
        return $this->redirectToRoute('app_classroom');
    }

    #[Route('/updateClassroom/{id}',name: 'classroom_update')]
    public function updateClassroom($id,ClassroomRepository $repo,ManagerRegistry $doctrine){
        $classroom = $repo->find($id);
        $classroom->setUsername('classroom updated');
        $entitymanager = $doctrine->getManager();
        $entitymanager->flush();
        return $this->redirectToRoute('app_classroom');
    }
}
