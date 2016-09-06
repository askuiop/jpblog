<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-7-31
 * Time: 下午2:42
 */

namespace BlogBundle\Doctrine;


use BlogBundle\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;


class HashPasswordListener implements EventSubscriber
{

	private $encoder;

	public function __construct(UserPasswordEncoder $encoder)
	{
		$this->encoder = $encoder;
	}
	public function prePersist(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();
		if (!$entity instanceof User) {
		  return ;
		}

		if ($entity->getNickname() === null) {
		    $entity->setNickname('');
		}

		if ($entity->getMail() === null) {
			$entity->setMail('');
		}


		$this->encoderPassword($entity);
	}

	public function preUpdate(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();
		if (!$entity instanceof User) {
			return ;
		}

		$this->encoderPassword($entity);

		// necessary to force the update to see the change
		$em = $args->getEntityManager();
		$meta = $em->getClassMetadata(get_class($entity));
		$em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
	}

	public function getSubscribedEvents() {
		return ["prePersist", "preUpdate"];
	}

	/**
	 * @param $entity
	 */
	private function encoderPassword(User $entity)
	{
		$encoded = $this->encoder->encodePassword($entity, $entity->getPlainPassword());
		$entity->setPassword($encoded);
	}
}