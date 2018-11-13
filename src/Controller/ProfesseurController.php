<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Maison;
use App\Entity\Note;
use App\Entity\Competence;
use App\Entity\Professeur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

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
	
	public function ajouterProfesseur()
	{
		
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
	
}
