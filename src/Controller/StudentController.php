<?php
namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class StudentController extends AbstractController {

    public function index1(){
        return new Response("Bonjour index 1");
    }

    #[Route('/welcome/{name}/{para2}')]
    public function indexPara($name,$para2){
        return new Response("Bonjour ".$name.' '.$para2);
    }
    #[Route('/student', name: 'app_student')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Student::class);
        $students=$repo->findAll();
        return $this->render('student/index.html.twig', [
            'students'=>$students
        ]);
    }
    #[Route('/addStudent',name:"Student_add")]
    public function addStudent(Request $req,StudentRepository $repo,ManagerRegistry $doctrine){
        $student = new Student();
        $form = $this->createForm(StudentType::class,$student);
        $form->handleRequest($req);
        $entitymanager=$doctrine->getManager();
        if($form->isSubmitted()){
            $entitymanager->persist($student);
            $entitymanager->flush();
            return $this->redirectToRoute('app_student');
        }
        return $this->render('student/addStudent.html.twig',[
            'form'=>$form->createView()
        ]);
        

    }

    #[Route('/updateStudent/{id}',name:"Student_update")]
    public function updateStudent(Request $req,$id,StudentRepository $repo,ManagerRegistry $doctrine){
        $student = $repo->find($id);
        $form=$this->createForm(StudentType::class,$student);
        $form->handleRequest($req);
        $entitymanager=$doctrine->getManager();
        if($form->isSubmitted()){
            $entitymanager->flush();
        return $this->redirectToRoute('app_student');
        }
        return $this->renderForm('student/addStudent.html.twig',[
            'form'=>$form
        ]);
    }
    #[Route('/deleteStudent/{id}',name: 'student_delete')]
    public function deleteClassroom($id,StudentRepository $repo){
        $student = $repo->find($id);
        $repo->remove($student,true);
        return $this->redirectToRoute('app_student');
    }
}
