<?php

namespace App\EventSubscriber\Entity;

/*
 * souscripteur d'entités doctrine
 *    déclencher des actions durant le cycle de vie d'une entité
 *
 */

use App\Entity\Decouvert;
use Doctrine\ORM\Events;
use App\Service\FileService;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DecouvertEventSubscriber implements EventSubscriber
{
	/*
	 * injecter un service dans un service non contrôleur
	 *      créer une propriété
	 *      créer un constructeur avec un paramètre réprésentant le service
	 *      dans le constructeur, lier la propriété et le paramètre
	 */
	private $fileService;

	public function __construct(FileService $fileService)
	{ 
		//$this->slugger = $slugger;
		$this->fileService = $fileService;
	}

	
	/*
	 * getSubscribedEvents doit retourner un array des événements à écouter
	 * principaux événements:
	 *      - postLoad : après le chargement d'une entité
	 *      - prePersist / postPersist : avant ou après la création d'une nouvelle entité dans la table (INSERT)
	 *      - preUpdate / postUpdate : avant ou après la mise à jour d'une entité dans la table (UPDATE)
	 *      - preRemove / postRemove : avant ou après la suppression d'une entité dans la table (DELETE)
	 *
	 * le nom des méthodes gérant les événements doivent reprendre strictement le nom de l'événement
	 *
	 * NE PAS OUBLIER de déclarer le souscripteur doctrine dans config/services.yaml
	 */
	public function getSubscribedEvents()
	{
		return [
			Events::prePersist,
			Events::postLoad,
			Events::preUpdate,
			Events::preRemove
		];
	}

	public function prePersist(LifecycleEventArgs $event):void
	{
		//dd(gettype($event->getObject()));
		// par défaut, les souscripteurs doctrine écoutent toutes les entités
		//if($event->getObject() instanceof Decouvert){
			$decouvert = $event->getObject();
			//$decouvert->setSlug( $this->slugger->slug($decouvert->getName())->lower() );

			//dd($decouvert->getImage());
			//transfert de l'image
			if($decouvert instanceof Decouvert && $decouvert->getImage() instanceof UploadedFile){
				//appelle d'un service
				$this->fileService->upload( $decouvert->getImage(), 'img/decouvert' );

				//recuperation de nom aleatoire du fichier genere dans le sevice
				$decouvert->setImage( $this->fileService->getFileName()) ;
			}
		}
	


	public function preUpdate(LifecycleEventArgs $args):void
	{
		if($args->getObject() instanceof Decouvert){
			$decouvert = $args->getObject();
			if($decouvert->getImage() instanceof UploadedFile) {
				$this->fileService->upload($decouvert->getImage(), 'img/decouvert');
				$decouvert->setImage($this->fileService->getFileName());

				//supprimer l'ancien image a partir de la propriete dynamique cree dans l'evement postLoad
				$this->fileService->delete( $decouvert->prevImage, 'img/decouvert' );
			}

			//si aucune image selectionné
			else{
				//recuperation de la proprieté dynamique crée dans l'evenement postLoad
				$decouvert->setImage( $decouvert->prevImage );
			}
			//$product = $args->getObject();
			//dd("pre update");
		}
	}


	public function postLoad(LifecycleEventArgs $args):void
	{
		if($args->getObject() instanceof Decouvert){
			//creation d'une propriété dynamique permettant de stocker le nom de l'image
			$decouvert = $args->getObject();
			$decouvert->prevImage = $decouvert->getImage();
		}
	}

	public function preRemove(LifecycleEventArgs $args):void
	{
		if($args->getObject() instanceof Decouvert){
			$decouvert = $args->getObject();
			//supprimer l'image a partir de la propriété dynamique crée dans l'evenement postLoad
			$this->fileService->delete($decouvert->prevImage, 'img/decouvert');
		}
	}

}







