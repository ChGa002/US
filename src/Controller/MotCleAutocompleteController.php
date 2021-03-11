<?php

namespace App\Controller;

use App\Repository\MotCleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MotCleAutocompleteController extends AbstractController
{
    /**
     * @Route("/utility/motcleautocomplete", name="utility_motcleautocomplete")
     */
    public function getMotsClesApi(MotCleRepository $motCleRepo)
    {
    	$objMotsCles = $motCleRepo->findAll();

    	$motsCles = array();

    	// Permet de recuperer le mot uniquement et pas l'objet
    	foreach ($objMotsCles as $motCle)
    	{
    		array_push($motsCles, $motCle->getMotCle());
    	}

    	return $this->json([
            'motsCles' => $motsCles
        ]);
    }
   
}
