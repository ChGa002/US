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
        $this->addFlash('success','Importé avec succès.');
        return $this->redirectToRoute('us_admin_dash');
    }
}

