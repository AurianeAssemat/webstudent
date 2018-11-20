<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Maison;
use App\Entity\Note;
use App\Entity\Competence;
use App\Entity\Professeur;

use App\Form\CompetenceType;
use App\Form\CompetenceModifierType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
	
	public function ajouterCompetence(Request $request)
	{
		$competence = new Competence();
		$form = $this->createForm(CompetenceType::class, $competence);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

            $competence = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competence);
            $entityManager->flush();
   
	    return $this->render('competence/consulter.html.twig', ['competence' => $competence,]);
		}
		else
        {
            return $this->render('competence/ajouter.html.twig', array('form' => $form->createView(),));
		}
		
		/* ancien code 06/11/2018 - 13/11/2018
		
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
			*/
		
	}
	
	public function consulterCompetence($id) {
		
		$competence = $this->getDoctrine()
        ->getRepository(Competence::class)
        ->find($id);

		if (!$competence) {
			throw $this->createNotFoundException(
            'Aucun competence trouvé avec le numéro '.$id
			);
		}

		//return new Response('Competence : '.$competence->getLibelle());
		return $this->render('competence/consulter.html.twig', [
            'competence' => $competence,]);
	}
	
	public function listerCompetence() {
		$repository = $this->getDoctrine()->getRepository(Competence::class);
		$competences = $repository->findAll();
		return $this->render('competence/lister.html.twig', [
            'pCompetences' => $competences,]);
	}
	
	public function modifierCompetence($id, Request $request){

	//récupération de l'étudiant dont l'id est passé en paramètre
	$competence = $this->getDoctrine()
		->getRepository(Competence::class)
		->find($id);

		if (!$competence) {
			throw $this->createNotFoundException('Aucun competence trouvé avec le numéro '.$id);
		}
		else
		{
            $form = $this->createForm(CompetenceModifierType::class, $competence);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                 $competence = $form->getData();
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($competence);
                 $entityManager->flush();
                 return $this->render('competence/consulter.html.twig', ['competence' => $competence,]);
           }
           else{
                return $this->render('competence/ajouter.html.twig', array('form' => $form->createView(),));
           }
        }
	}
	
}
