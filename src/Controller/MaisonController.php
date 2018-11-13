<?php

namespace App\Controller;

use App\Entity\Maison;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MaisonController extends AbstractController
{
    /**
     * @Route("/maison", name="maison")
     */
    public function index()
    {
        return $this->render('maison/index.html.twig', [
            'controller_name' => 'MaisonController',
        ]);
    }
	
	public function ajouterMaison()
	{
		
	// récupère le manager d'entités
        $entityManager = $this->getDoctrine()->getManager();

        // instanciation d'un objet Maison
        $maison = new Maison();
        $maison->setCode('');
        $maison->setNom('');
		
        // Indique à Doctrine de persister l'objet
        $entityManager->persist($maison);

        // Exécue l'instruction sql permettant de persister lobjet, ici un INSERT INTO
        $entityManager->flush();

        // renvoie vers la vue de consultation de l'étudiant en passant l'objet maison en paramètre
       return $this->render('maison/consulter.html.twig', [
            'maison' => $maison,]);
		
	}
	
	public function consulterMaison($id)
	{
		
		$maison = $this->getDoctrine()
        ->getRepository(Maison::class)
        ->find($id);

		if (!$maison) {
			throw $this->createNotFoundException(
            'Aucun maison trouvé avec le numéro '.$id
			);
		}

		//return new Response('Maison : '.$maison->getNom());
		return $this->render('maison/consulter.html.twig', [
            'maison' => $maison,]);
	}
	
	public function listerMaison()
	{
		$repository = $this->getDoctrine()->getRepository(Maison::class);
		$maisons = $repository->findAll();
		return $this->render('maison/lister.html.twig', [
            'pMaisons' => $maisons,]);
	}
	
}
