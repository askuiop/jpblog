<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-7-31
 * Time: 上午11:00
 */

namespace BlogBundle\Security;


use BlogBundle\Entity\User;
use BlogBundle\Form\LoginType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{

	use TargetPathTrait;

	private $formFactory;
	private $em;
	private $router;
	/**
	 * @var SessionInterface
	 */
	private $session;
  /**
   * @var UserPasswordEncoder
   */
  private $encoder;

  public function __construct(FormFactoryInterface $formFactory, EntityManager $em, RouterInterface $router, SessionInterface $session , UserPasswordEncoder $encoder)
	{
		$this->formFactory = $formFactory;
		$this->em = $em;
		$this->router = $router;
		$this->session = $session;
    $this->encoder = $encoder;
  }
	public function getCredentials(Request $request)
	{
		$isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod("POST");
		if (!$isLoginSubmit) {
		    return ;
		}

		$form = $this->formFactory->create(LoginType::class);
		$form->handleRequest($request);

		$data = $form->getData();

		$request->getSession()->set(Security::LAST_USERNAME, $data['_username'] );

		return $data;

	}

	public function getUser($credentials, UserProviderInterface $userProvider)
	{
    $username = $credentials['_username'];
		return $userProvider->loadUserByUsername($username);
	}

	public function checkCredentials($credentials, UserInterface $user)
	{
		$password = $credentials['_password'];

    if ($this->encoder->isPasswordValid($user, $password)) {
      return true;
    }
    return false;

	}


	protected function getLoginUrl() {
		 return $this->router->generate('blog_security_login');
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
	{
		dump($request);

		dump($providerKey);

		$path = $this->getTargetPath($this->session, $providerKey);

		dump($path);

		if ($path) {
			$url =  $path;
		} else {
			$url = $this->router->generate('blog_homepage');
		}



		return new RedirectResponse($url);
	}

	public function start(Request $request, AuthenticationException $authException = null)
	{
		//dump($authException);
		//dump($authException->getPrevious()->getTraceRoute());
		//die();

		$url = $this->getLoginUrl();

		return new RedirectResponse($url);
	}


}