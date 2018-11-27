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


use App\Form\EntrepriseType;
use App\Form\EntrepriseModifierType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EntrepriseController extends AbstractController
{
    /**
     * @Route("/entreprise", name="entreprise")
     */
    public function index()
    {
        return $this->render('entreprise/index.html.twig', [
            'controller_name' => 'EntrepriseController',
        ]);
    }
	
	public function ajouterEntreprise(Request $request)
	{
		$entreprise = new Entreprise();
		$form = $this->createForm(EntrepriseType::class, $entreprise);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

            $entreprise = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entreprise);
            $entityManager->flush();
   
	    return $this->render('entreprise/consulter.html.twig', ['entreprise' => $entreprise,]);
		}
		else
        {
            return $this->render('entreprise/ajouter.html.twig', array('form' => $form->createView(),));
		}
		
	}
	
	public function consulterEntreprise($id) {
		
		$entreprise = $this->getDoctrine()
        ->getRepository(Entreprise::class)
        ->find($id);

		if (!$entreprise) {
			throw $this->createNotFoundException(
            'Aucun entreprise trouvé avec le numéro '.$id
			);
		}

		//return new Response('Entreprise : '.$entreprise->getLibelle());
		return $this->render('entreprise/consulter.html.twig', [
            'entreprise' => $entreprise,]);
	}
	
	public function listerEntreprise() {
		$repository = $this->getDoctrine()->getRepository(Entreprise::class);
		$entreprises = $repository->findAll();
		return $this->render('entreprise/lister.html.twig', [
            'pEntreprises' => $entreprises,]);
	}
	
	public function modifierEntreprise($id, Request $request){

	//récupération de l'étudiant dont l'id est passé en paramètre
	$entreprise = $this->getDoctrine()
		->getRepository(Entreprise::class)
		->find($id);

		if (!$entreprise) {
			throw $this->createNotFoundException('Aucun entreprise trouvé avec le numéro '.$id);
		}
		else
		{
            $form = $this->createForm(EntrepriseModifierType::class, $entreprise);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                 $entreprise = $form->getData();
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($entreprise);
                 $entityManager->flush();
                 return $this->render('entreprise/consulter.html.twig', ['entreprise' => $entreprise,]);
           }
           else{
                return $this->render('entreprise/ajouter.html.twig', array('form' => $form->createView(),));
           }
        }
	}
}
