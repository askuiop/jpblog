<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-8-3
 * Time: 下午1:06
 */

namespace BlogBundle\Security;


use BlogBundle\Entity\Post;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\DebugAccessDecisionManager;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Role\RoleHierarchy;

class BlogVoter extends Voter
{
	/**
	 * @var Container
	 */
	private $container;
	/**
	 * @var AuthorizationChecker
	 */
	private $checker;
	/**
	 * @var AccessDecisionManagerInterface
	 */
	private $decisionManager;
	/**
	 * @var RoleHierarchy
	 */
	private $roleHierarchy;

	public function __construct(Container $container,  AccessDecisionManagerInterface $decisionManager, RoleHierarchy $roleHierarchy)
	{
		//dump($decisionManager);

		//die();
		$this->container = $container;
		//$this->checker = $checker;
		$this->decisionManager = $decisionManager;
		$this->roleHierarchy = $roleHierarchy;
	}
	protected function supports($attribute, $subject)
	{
		if (! ( strpos($attribute, 'POST' )===0  && $subject instanceof Post) ) {
			return false;
		} else {
			return true;
		}
	}

	protected function hasRole($token,$targetRole)
	{
		$reachableRoles = $this->roleHierarchy->getReachableRoles($token->getRoles());
		dump($reachableRoles);
		foreach($reachableRoles as $role)
		{
			if ($role->getRole() == $targetRole) return true;
		}
		return false;
	}

	protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
	{

		/* way 1
		if (!$this->container->get("security.authorization_checker")
			->isGranted('ROLE_USER')) {
			return false;
		}*/

		/* way 2
		if (!$this->checker->isGranted('ROLE_USER')) {
			return false;
		}*/

		// way 3
		//if (!$this->decisionManager->decide($token, array('ROLE_USER'))) {
		//	return false;
		//}

		//way 4
		if (!$this->hasRole($token, "ROLE_USER")) {
			return false;
		}

		/**
		 * @var $subject Post
		 */
		$subject = $subject;

		$user = $token->getUser();
		if ($attribute=="POST_EDIT") {
			//dump($user);
			//dump($subject->getUser());

			return $user===$subject->getUser();
		}
	}


}