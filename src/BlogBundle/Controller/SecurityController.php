<?php

namespace BlogBundle\Controller;

use BlogBundle\Form\LoginType;

use BlogBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

      if ($error) {
        dump($error->getMessage());
      }



        $login_form = $this->createForm(LoginType::class, [
            '_username' => $lastUsername
        ]);
        $form_view = $login_form->createView();

        return $this->render(
          '@Blog/security/login.html.twig',
          array(
            'login_form' => $form_view,
            'error' => $error,
          )
        );
    }

    public function logoutAction()
    {
        throw  new \Exception("this  should not be reached !");
    }

    public function registAction(Request $request)
    {
        $form = $this->createForm(RegisterType::class);

        $form->handleRequest($request);
        if($form->isValid()){
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->addFlash('success', 'welcome'.$user->getUsername());

            return $this->get("security.authentication.guard_handler")
                ->authenticateUserAndHandleSuccess(
                  $user,
                  $request,
                  $this->get("blog.security.from.login"),
                  'main'
                );


            //return $this->redirectToRoute('post_index');
            
        }

        return $this->render('@Blog/security/register.html.twig',[
            'register_form' => $form->createView()
        ]);
    }
}
