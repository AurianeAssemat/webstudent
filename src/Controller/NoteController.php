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

class NoteController extends AbstractController
{
    /**
     * @Route("/note", name="note")
     */
    public function index()
    {
        return $this->render('note/index.html.twig', [
            'controller_name' => 'NoteController',
        ]);
    }
	
	public function consulterNote($id)
	{
		
		$note = $this->getDoctrine()
        ->getRepository(Note::class)
        ->find($id);

		if (!$note) {
			throw $this->createNotFoundException(
            'Aucun note trouvé avec le numéro '.$id
			);
		}
		
		//var_dump($note);

		//return new Response('Note : '.$note->getNote());
		return $this->render('note/consulter.html.twig', [
            'note' => $note,]);
	}
	
	public function listerNote()
	{
		$repository = $this->getDoctrine()->getRepository(Note::class);
		$notes = $repository->findAll();
		return $this->render('note/lister.html.twig', [
            'pNotes' => $notes,]);
	}
	
}
