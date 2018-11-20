<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Maison;
use App\Entity\Note;
use App\Entity\Competence;
use App\Entity\Professeur;
use App\Form\EtudiantType;
use App\Form\EtudiantModifierType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant", name="etudiant")
     */
    public function index()
    {
        /* Cette simple instruction permet d'envoyer des informations au navigateur sans passer par une vue.
        return new Response('<html><body>Salut Les SIO</body></html>');
        */

        // initialise une variable qui sera exploitée dans la vue
        $annee = '2019';
        return $this->render('etudiant/accueil.html.twig', ['pAnnee' => $annee,
        ]);
    }
	
	public function ajouterEtudiant(Request $request)
	{
		
		$etudiant = new Etudiant();
		$form = $this->createForm(EtudiantType::class, $etudiant);
		/*code du 20/11/2018
		
		return $this->render('etudiant/ajouter.html.twig', array('form' => $form->createView(), ));
		
		*/
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$etudiant = $form->getData();

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($etudiant);
			$entityManager->flush();
	   
			return $this->render('etudiant/consulter.html.twig', ['etudiant' => $etudiant,]);
		}
		else{
			return $this->render('etudiant/ajouter.html.twig', array('form' => $form->createView(),));
		}
		
		/* ancien code 06/11/2018 - 13/11/2018
		
	// récupère le manager d'entités
        $entityManager = $this->getDoctrine()->getManager();

        // instanciation d'un objet Etudiant
        $etudiant = new Etudiant();
        $etudiant->setNom('');
        $etudiant->setPrenom('');
        $etudiant->setDtNaissance(new \DateTime(date('1980-01-01')));
		$etudiant->setVille('');
		$etudiant->setCopos('');
		$etudiant->setRue('');
		$etudiant->setSurnom('');
		$etudiant->setNumrue(0);

        // Indique à Doctrine de persister l'objet
        $entityManager->persist($etudiant);

        // Exécue l'instruction sql permettant de persister lobjet, ici un INSERT INTO
        $entityManager->flush();

        // renvoie vers la vue de consultation de l'étudiant en passant l'objet etudiant en paramètre
       return $this->render('etudiant/consulter.html.twig', [
            'etudiant' => $etudiant,]); 
			*/
		
	}
	
	public function consulterEtudiant($id)
	{
		
		$etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($id);

		if (!$etudiant) {
			throw $this->createNotFoundException(
            'Aucun etudiant trouvé avec le numéro '.$id
			);
		}

		//return new Response('Etudiant : '.$etudiant->getNom());
		return $this->render('etudiant/consulter.html.twig', [
            'etudiant' => $etudiant,]);
	}
	
	public function listerEtudiant()
	{
		$repository = $this->getDoctrine()->getRepository(Etudiant::class);
		$etudiants = $repository->findAll();
		return $this->render('etudiant/lister.html.twig', [
            'pEtudiants' => $etudiants,]);
	}
	
	public function modifierEtudiant($id, Request $request){

	//récupération de l'étudiant dont l'id est passé en paramètre
	$etudiant = $this->getDoctrine()
		->getRepository(Etudiant::class)
		->find($id);

		if (!$etudiant) {
			throw $this->createNotFoundException('Aucun etudiant trouvé avec le numéro '.$id);
		}
		else
		{
            $form = $this->createForm(EtudiantModifierType::class, $etudiant);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                 $etudiant = $form->getData();
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($etudiant);
                 $entityManager->flush();
                 return $this->render('etudiant/consulter.html.twig', ['etudiant' => $etudiant,]);
           }
           else{
                return $this->render('etudiant/ajouter.html.twig', array('form' => $form->createView(),));
           }
        }
	
		/* ancien code 06/11/2018 - 13/11/2018
		
		//récupération de l'étudiant dont l'id est passé en paramètre
		$etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($id);

		if (!$etudiant) {
			throw $this->createNotFoundException(
            'Aucun etudiant trouvé avec le numéro '.$id
			);
		}
		else
		{


		// récupération de la maison des griffondor à partir du code de la maison
		$maison = $this->getDoctrine()
        ->getRepository(Maison::class)
        ->findOneByCode('GFD');

		if (!$maison) {
			throw $this->createNotFoundException(
            'Aucune maison trouvé avec ce nom'
			);
		}
		else
		{

		//Affectation de la maison à l'étudiant
		$etudiant->setMaison($maison);

		// persistence de l'objet modifié
                $entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist($etudiant);
		$entityManager->flush();



		//return new Response('Etudiant : '.$etudiant->getNom());
		return $this->render('etudiant/consulter.html.twig', [
            'etudiant' => $etudiant,]);
        }
        }
		
		*/
	}
}
