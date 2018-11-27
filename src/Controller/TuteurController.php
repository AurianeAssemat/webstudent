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


use App\Form\TuteurType;
use App\Form\TuteurModifierType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class TuteurController extends AbstractController
{
    /**
     * @Route("/tuteur", name="tuteur")
     */
    public function index()
    {
        return $this->render('tuteur/index.html.twig', [
            'controller_name' => 'TuteurController',
        ]);
    }
	
	public function ajouterTuteur(Request $request)
	{
		$tuteur = new Tuteur();
		$form = $this->createForm(TuteurType::class, $tuteur);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

            $tuteur = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tuteur);
            $entityManager->flush();
   
	    return $this->render('tuteur/consulter.html.twig', ['tuteur' => $tuteur,]);
		}
		else
        {
            return $this->render('tuteur/ajouter.html.twig', array('form' => $form->createView(),));
		}
		
	}
	
	public function consulterTuteur($id) {
		
		$tuteur = $this->getDoctrine()
        ->getRepository(Tuteur::class)
        ->find($id);

		if (!$tuteur) {
			throw $this->createNotFoundException(
            'Aucun tuteur trouvé avec le numéro '.$id
			);
		}

		//return new Response('Tuteur : '.$tuteur->getLibelle());
		return $this->render('tuteur/consulter.html.twig', [
            'tuteur' => $tuteur,]);
	}
	
	public function listerTuteur() {
		$repository = $this->getDoctrine()->getRepository(Tuteur::class);
		$tuteurs = $repository->findAll();
		return $this->render('tuteur/lister.html.twig', [
            'pTuteurs' => $tuteurs,]);
	}
	
	public function modifierTuteur($id, Request $request){

	//récupération de l'étudiant dont l'id est passé en paramètre
	$tuteur = $this->getDoctrine()
		->getRepository(Tuteur::class)
		->find($id);

		if (!$tuteur) {
			throw $this->createNotFoundException('Aucun tuteur trouvé avec le numéro '.$id);
		}
		else
		{
            $form = $this->createForm(TuteurModifierType::class, $tuteur);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                 $tuteur = $form->getData();
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($tuteur);
                 $entityManager->flush();
                 return $this->render('tuteur/consulter.html.twig', ['tuteur' => $tuteur,]);
           }
           else{
                return $this->render('tuteur/ajouter.html.twig', array('form' => $form->createView(),));
           }
        }
	}
}
