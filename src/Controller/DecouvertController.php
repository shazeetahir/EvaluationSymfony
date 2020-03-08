<?php

namespace App\Controller;

use App\Entity\Decouvert;
use App\Form\DecouvertType;
use App\Repository\DecouvertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DecouvertController extends AbstractController
{
    /**
     * @Route("/decouvert", name="decouvert.index")
     */
    public function index(DecouvertRepository $decouvertRepository):Response
    {
		//les articles de voyage classés par continent
        $results = $decouvertRepository->findAllOrdered();

        return $this->render('decouvert/index.html.twig', [
            'controller_name' => 'DecouvertController',
            'results' => $results
        ]);
	}

	

	/**
	 * @Route("/decouvert/delete/{id}", name="decouvert.delete")
	 */
	public function delete(DecouvertRepository $decouvertRepository, EntityManagerInterface $entityManager, int $id):Response
	{
		/**
		 * avec doctrine, pour supprimer une entite, il faut la selectionner au prealable
		 * methode remove pour DELETE
		 */
		$entity = $decouvertRepository->find($id);
		$entityManager->remove($entity);
		$entityManager->flush();

		//message de confirmation et redirection
		$this->addFlash('notice', 'Le produit a été supprimé');
		return $this->redirectToRoute('decouvert.index');
	}

    /**
	 * @Route("/decouvert/form", name="decouvert.add")
	 * @Route("/decouvert/form/update/{id}", name="decouvert.update")
	 */
	public function form(Request $request, EntityManagerInterface $entityManager, int $id= null, DecouvertRepository $decouvertRepository):Response
	{
		// affichage d'un formulaire
		$type = DecouvertType::class;
		$model = $id ? $decouvertRepository->find($id) : new Decouvert();
		$form = $this->createForm($type, $model);
		$form->handleRequest($request);

		// si le formulaire est valide
		if($form->isSubmitted() && $form->isValid()){

		//dd($request);
			//dd($model);
			/*
			 * insertion dans une table
			 * EntityManagerInterface permet d'exécuter UPDATE, DELETE, INSERT
			 *   méthode persist permet un INSERT
			 *   lors d'un UPDATE , aucune methode n'est requise
			 *   méthode flush permet d'exécuter les requêtes
			 */
			$entityManager->persist($model);
			$entityManager->flush();

			// message de confirmation
			//	$message = $id ? "Le produit a été modifié" : "Le produit a été ajouté";
			//$this->addFlash('notice', $message);

			// redirection
			return $this->redirectToRoute('decouvert.index');
		}

		return $this->render('decouvert/add.html.twig', [
			'form' => $form->createView(),
			'decouvert' => $model
		]);
	}

    








    

    /**
	 * @Route("/decouvert/{id}", name="decouvert.details")
	 */

	public function details(int $id, DecouvertRepository $decouvertRepository):Response
	{
		/*
		 * findOneBy nécessite une liste de conditions sur les propriétés de l'entité
		 *      clé est l'une des propriétés de l'entité
		 */
		$decouvert = $decouvertRepository->find($id);

		return $this->render('decouvert/details.html.twig', [
			'decouvert' => $decouvert
		]);
    }
}
