<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Maison;
use App\Entity\Note;
use App\Entity\Competence;
use App\Entity\Professeur;
use App\Entity\Tuteur;
use App\Entity\Entreprise;
use App\Entity\Stage;


use App\Form\StageType;
use App\Form\StageModifierType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class StageController extends AbstractController
{
    /**
     * @Route("/stage", name="stage")
     */
    public function index()
    {
        return $this->render('stage/index.html.twig', [
            'controller_name' => 'StageController',
        ]);
    }
	
	public function ajouterStage(Request $request)
	{
		$stage = new Stage();
		$form = $this->createForm(StageType::class, $stage);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

            $stage = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stage);
            $entityManager->flush();
   
	    return $this->render('stage/consulter.html.twig', ['stage' => $stage,]);
		}
		else
        {
            return $this->render('stage/ajouter.html.twig', array('form' => $form->createView(),));
		}
		
	}
	
	public function consulterStage($id) {
		
		$stage = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->find($id);

		if (!$stage) {
			throw $this->createNotFoundException(
            'Aucun stage trouvé avec le numéro '.$id
			);
		}

		//return new Response('Stage : '.$stage->getLibelle());
		return $this->render('stage/consulter.html.twig', [
            'stage' => $stage,]);
	}
	
	public function listerStage() {
		$repository = $this->getDoctrine()->getRepository(Stage::class);
		$stages = $repository->findAll();
		return $this->render('stage/lister.html.twig', [
            'pStages' => $stages,]);
	}
	
	public function modifierStage($id, Request $request){

	//récupération de l'étudiant dont l'id est passé en paramètre
	$stage = $this->getDoctrine()
		->getRepository(Stage::class)
		->find($id);

		if (!$stage) {
			throw $this->createNotFoundException('Aucun stage trouvé avec le numéro '.$id);
		}
		else
		{
            $form = $this->createForm(StageModifierType::class, $stage);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                 $stage = $form->getData();
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($stage);
                 $entityManager->flush();
                 return $this->render('stage/consulter.html.twig', ['stage' => $stage,]);
           }
           else{
                return $this->render('stage/ajouter.html.twig', array('form' => $form->createView(),));
           }
        }
	}
}
