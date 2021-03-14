<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Psr\Log\LoggerInterface;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImporterUserCSVController extends AbstractController
{
    /** 
     * @Route("/admin/importation-utilisateurs", name="us_importUsersCSV")
     */
    public function importUsersCSV(Request $request, EntityManagerInterface $em): Response
    {
        return $this->render('admin/import.html.twig');
    }



    // public function upload(Request $request, EntityManagerInterface $em)
    // {
    //     /** @var UploadedFile $file*/
    //     $file = $request->query->get('upload');
    //     dump($request->files->all());
    //     // dd($file->getPathName() );
    //     dump($_POST);
       
    //     // $file2 = $request->query->get('upload')->getData();   
    //     // $destination = $this->getParameter('kernel.project_dir').'/public/data';
    //     // dd($file->move($destination));
                    
    //     // Open the file
    //     // if (($handle = fopen($file->getPathname(), "r")) !== false) {
    //     // // Read and process the lines. 
    //     // // Skip the first line if the file includes a header
    //     // while (($data = fgetcsv($handle)) !== false) {
    //     //                     // Do the processing: Map line to entity, validate if needed
    //     //                     $user = new Utilisateur();
    //     //                     // Assign fields
    //     //                     $user->setField1($data[0])
    //     //                             ->setField1($data[1])
    //     //                             ->setField1($data[2]);
    //     //                     $em->persist($user);
    //     //                 }
    //     //                 fclose($handle);
    //     //                 $em->flush();
    //     //             }
    // dump($file);
    // }
    /** 
     * @Route("/admin/importation-utilisateurs/upload", name="us_importation_upload")
     */
    public function index(Request $request, EntityManagerInterface $em, UtilisateurRepository $userRepo): Response
    {
        $file = $request->files->get('upload');
        // dd($file);
        // Open the file
        if (($handle = fopen($file->getPathname(), "r")) !== false) 
        {
            // Read and process the lines. 
            // Skip the first line if the file includes a header
            while (($data = fgetcsv($handle)) !== false) 
            {
                $champ = explode(';',$data[0]);
                if( $champ[2] != 'mail')
                {
                    if( $userRepo->findOneByMail($champ[2]) == null )
                    {
                        // Do the processing: Map line to entity, validate if needed
                        $user = new Utilisateur();
                        // Assign fields
                        $user->setNom($champ[0])
                                ->setPrenom($champ[1])
                                ->setMail($champ[2]);
                        $em->persist($user);
                    }
                }
            }
            fclose($handle);
            $em->flush();
        }
        return $this->redirectToRoute('us_importUsersCSV');
    }
}

