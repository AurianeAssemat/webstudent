<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Maison;
use App\Entity\Note;
use App\Entity\Competence;
use App\Entity\Professeur;
use App\Form\ProfesseurType;
use App\Form\ProfesseurModifierType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ProfesseurController extends AbstractController
{
    /**
     * @Route("/professeur", name="professeur")
     */
    public function index()
    {
        return $this->render('professeur/index.html.twig', [
            'controller_name' => 'ProfesseurController',
        ]);
    }
	
	public function ajouterProfesseur(Request $request)
	{
		$professeur = new Professeur();
		$form = $this->createForm(ProfesseurType::class, $professeur);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$professeur = $form->getData();

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($professeur);
			$entityManager->flush();
	   
			return $this->render('professeur/consulter.html.twig', ['professeur' => $professeur,]);
		}
		else{
			return $this->render('professeur/ajouter.html.twig', array('form' => $form->createView(),));
		}
		
		/* ancien code 06/11/2018 - 13/11/2018
		
	// récupère le manager d'entités
        $entityManager = $this->getDoctrine()->getManager();

        // instanciation d'un objet Professeur
        $professeur = new Professeur();
        $professeur->setNom('');
        $professeur->setPrenom('');
        $professeur->setDtNaissance(new \DateTime(date('1900-01-01')));

        // Indique à Doctrine de persister l'objet
        $entityManager->persist($professeur);

        // Exécue l'instruction sql permettant de persister lobjet, ici un INSERT INTO
        $entityManager->flush();

        // renvoie vers la vue de consultation de l'étudiant en passant l'objet professeur en paramètre
       return $this->render('professeur/consulter.html.twig', [
            'professeur' => $professeur,]);
			*/
		
	}
	
	public function consulterProfesseur($id)
	{
		
		$professeur = $this->getDoctrine()
        ->getRepository(Professeur::class)
        ->find($id);

		if (!$professeur) {
			throw $this->createNotFoundException(
            'Aucun professeur trouvé avec le numéro '.$id
			);
		}

		//return new Response('Professeur : '.$professeur->getNom());
		return $this->render('professeur/consulter.html.twig', [
            'professeur' => $professeur,]);
	}
	
	public function listerProfesseur()
	{
		$repository = $this->getDoctrine()->getRepository(Professeur::class);
		$professeurs = $repository->findAll();
		return $this->render('professeur/lister.html.twig', [
            'pProfesseurs' => $professeurs,]);
	}
	
	public function modifierProfesseur($id, Request $request){

		//récupération du professeur dont l'id est passé en paramètre
		$professeur = $this->getDoctrine()
		->getRepository(Professeur::class)
		->find($id);

		if (!$professeur) {
			throw $this->createNotFoundException('Aucun professeur trouvé avec le numéro '.$id);
		}
		else
		{
            $form = $this->createForm(ProfesseurModifierType::class, $professeur);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                 $professeur = $form->getData();
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($professeur);
                 $entityManager->flush();
                 return $this->render('professeur/consulter.html.twig', ['professeur' => $professeur,]);
           }
           else{
                return $this->render('professeur/ajouter.html.twig', array('form' => $form->createView(),));
           }
        }
	}
	
	/*fct ajout d'une competence
	public function ajouterCompetenceProfesseur($id, Request $request)
	{
		//récupération du professeur dont l'id est passé en paramètre
		$professeur = $this->getDoctrine()
		->getRepository(Professeur::class)
		->find($id);

		if (!$professeur) {
			throw $this->createNotFoundException('Aucun professeur trouvé avec le numéro '.$id);
		}
		else
		{
            $form = $this->createForm(ProfesseurCompetenceType::class, $professeur);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                 $competences = $form->getData();
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($professeur);
                 $entityManager->flush();
                 return $this->render('professeur/consulter.html.twig', ['professeur' => $professeur,]);
           }
           else{
                return $this->render('professeur/ajouter.html.twig', array('form' => $form->createView(),));
           }
        }
	} */
}
