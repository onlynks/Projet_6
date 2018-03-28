<?php

namespace P6\PlatformBundle\Controller;

use P6\PlatformBundle\Entity\Trick;
use P6\PlatformBundle\Form\MessageType;
use P6\PlatformBundle\Form\TrickType;
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
     * @Route ("/", name="p6_homepage")
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
            'trick'=> $trick,
        ));

$url = "https://www.youtube.com/watch?v=5QJu0MbbTnk";
parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
echo $my_array_of_vars['v'];
  // Output: C4kxS1ksqtw

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

        $form = $this->get('form.factory')->create(TrickType::class, $trick);


        $form->handleRequest($request);

        if($form->isValid())
        {
            $images = $form['images']->getNormData();

            $fileUploader = $this->get('image.uploader');

            foreach ($images as $image)
            {
                $name = $fileUploader->upload($image->getFIle());
                $image->setTrick($trick);
                $image->setFile($name);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();

            $content = $this->redirectToRoute('p6_onetrick', array('id' => $trick->getId()));
            return new Response($content);
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

    /**
     * @Route ("/category/{id}", name="p6_category")
     * @return Response
     */
    public function oneCategoryAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('P6PlatformBundle:Category')->find($id);

        $tricks = $em->getRepository('P6PlatformBundle:Trick')->findAll();

        $content = $this->renderView('@P6Platform/Platform/category.html.twig', array(
            'category' => $category,
            'tricks' => $tricks
        ));

        return new Response($content);
    }


    public function menuAction()
    {
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            {
                $user = $this->getUser();
            }
        else
            {
                $user = null;
            }

        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('P6PlatformBundle:Category')->findAll();

        $content = $this->renderView('menu.html.twig', array(
            'categories' => $categories,
            'user' => $user
        ));

        return new Response($content);

    }

    /**
     * @param $id
     * @Route ("delete/{id}", name="p6_deleteTrick")
     * @return Response
     */
    public function deleteTrick($id)
    {

        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository('P6PlatformBundle:Trick')->find($id);

        $em->remove($trick);
        $em->flush();

        return new Response($this->redirectToRoute('p6_homepage'));
    }
}


