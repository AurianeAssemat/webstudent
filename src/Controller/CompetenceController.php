<?php

namespace App\Controller;

use App\Entity\Competence;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CompetenceController extends AbstractController
{
    /**
     * @Route("/competence", name="competence")
     */
    public function index()
    {
        return $this->render('competence/index.html.twig', [
            'controller_name' => 'CompetenceController',
        ]);
    }
	
	public function ajouterCompetence()
	{
		
	// récupère le manager d'entités
        $entityManager = $this->getDoctrine()->getManager();

        // instanciation d'un objet Competence
        $competence = new Competence();
        $competence->setCode('');
        $competence->setLibelle('');;
		$competence->setNbEtudiantsMax(2);

        // Indique à Doctrine de persister l'objet
        $entityManager->persist($competence);

        // Exécue l'instruction sql permettant de persister lobjet, ici un INSERT INTO
        $entityManager->flush();

        // renvoie vers la vue de consultation de l'étudiant en passant l'objet competence en paramètre
       return $this->render('competence/consulter.html.twig', [
            'competence' => $competence,]);
		
	}
	
	public function consulterCompetence($id)
	{
		
		$competence = $this->getDoctrine()
        ->getRepository(Competence::class)
        ->find($id);

		if (!$competence) {
			throw $this->createNotFoundException(
            'Aucun competence trouvé avec le numéro '.$id
			);
		}

		//return new Response('Competence : '.$competence->getNom());
		return $this->render('competence/consulter.html.twig', [
            'competence' => $competence,]);
	}
	
	public function listerCompetence()
	{
		$repository = $this->getDoctrine()->getRepository(Competence::class);
		$competences = $repository->findAll();
		return $this->render('competence/lister.html.twig', [
            'pCompetences' => $competences,]);
	}
	
}
