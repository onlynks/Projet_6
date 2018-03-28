<?php


namespace P6\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use P6\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Response;
use P6\UserBundle\Entity\User;


class SecurityController extends Controller
{
    /**
     * @Route ("/login", name="login")
     **/
    public function loginAction($username = null, $password = null)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('p6_homepage');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('@P6User/Security/login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
            'username' => $username,
            'password' => $password
        ));
    }

    /**
     * @return Response
     * @Route("/registration", name="p6_registration")
     */
    public function registration(Request $request)
    {
        $user = new User();
        $user->setRoles(array('ROLE_USER'));
        $user->setSalt('');

        $form = $this->get('form.factory')->create(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            if($form->isValid())
            {
                $photo = $form['photo']->getNormData();
                $fileUploader = $this->get('image.uploader');
                $name = $fileUploader->upload($photo);
                $user->setPhoto($name);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $content = $this->redirectToRoute('login');
                return new Response($content);
            }
        }

        $content = $this->renderView('@P6User/Security/register.html.twig', array(
            'form' => $form->createView(),
        ));

        return new Response($content);


    }

}
