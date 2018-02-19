<?php

namespace P6\PlatformBundle\Controller;


use P6\PlatformBundle\Entity\Category;
use P6\PlatformBundle\Entity\Trick;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;



class TrickController extends Controller
{
    public function indexAction()
    {
        return $this->render('P6PlatformBundle:Default:index.html.twig');
    }


    /**
     * @Route ("/homepage", name="p6_homepage")
     * @return Response
     */
    public function homepageAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('P6PlatformBundle:Category');
        $listCategories = $categories->findAll();

        $content = $this->renderView('@P6Platform/Platform/homepage.html.twig', array(
            'listCategories'=>$listCategories
        ));

        return new Response($content);

    }

    /**
     * @Route ("/trick/{id}", name="p6_onetrick")
     * @return Response
     */
    public function oneTrickAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $trick = $em->getRepository('P6PlatformBundle:Trick')->find($id);


        $content = $this->renderView('@P6Platform/Platform/trick.html.twig', array(
            'trick'=>$trick
        ));

        return new Response($content);

    }

    /**
     * @Route ("/updateTrick/{id}", name="p6_updateTrick")
     * @return Response
     */
    public function updateTrickAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository('P6PlatformBundle:Trick')->find($id);

        $form = $this->createFormBuilder($trick)
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('Enregistrer',      SubmitType::class)
            ->getForm();

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($trick);
                $em->flush();

                $content = $this->redirectToRoute('p6_onetrick', array('id' => $trick->getId()));
                return new Response($content);
            }
        }

        $content = $this->renderView('@P6Platform/Platform/updateTrick.html.twig', array(
            'form' => $form->createView(),
        ));
        return new Response($content);
    }

    /**
     * @Route ("/addtrick", name="p6_addtrick")
     * @return Response
     */
    public function addTrickAction(Request $request)
    {
        $trick = new Trick();

        $form = $this->createFormBuilder($trick)
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('Enregistrer',      SubmitType::class)
            ->getForm();

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($trick);
                $em->flush();

                $content = $this->redirectToRoute('p6_onetrick', array('id' => $trick->getId()));
                return new Response($content);
            }
        }

        $content = $this->renderView('@P6Platform/Platform/addTrick.html.twig', array(
            'form' => $form->createView(),
        ));
        return new Response($content);
    }

    /**
     * @Route ("/addTC", name="p6_addTC")
     * @return Response
     */
    public function AddTrickCategoryAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('P6PlatformBundle:Category');
        $listCategories = $categories->findAll();

        $tricks = $em->getRepository('P6PlatformBundle:Trick');
        $listTricks = $tricks->findAll();

        $randomTrick = $listTricks[0];
        $randomTrick->addCategory($listCategories[0]);


        foreach($listTricks as $trick)
        {
            $randomCategory = array_rand($listCategories);
            $trick->addCategory($listCategories[$randomCategory]);
            $em->persist($trick);
        }

        $em->flush();

        return new Response("Categories added");
    }
}


