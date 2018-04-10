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
use P6\PlatformBundle\Entity\Message;




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

        $tricks = $em->getRepository('P6PlatformBundle:Trick');
        $listTricks = $tricks->findAll();
        $homepage = true;

        $content = $this->renderView('@P6Platform/Platform/homepage.html.twig', array(
            'listTricks'=>$listTricks,
            'homepage' => $homepage
        ));

        return new Response($content);

    }

    /**
     * @Route ("/trick/{id}", name="p6_onetrick")
     * @return Response
     */
    public function oneTrickAction($id, $request = null)
    {

        $em = $this->getDoctrine()->getManager();

        $trick = $em->getRepository('P6PlatformBundle:Trick')->find($id);

        $message = new Message();
        $form = $this->get('form.factory')->create(MessageType::class, $message);

        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')&& $request !== null)
        {
            $user = $this->getUser();
            $message->setTrick($trick)->setUser($user);
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em->persist($message);
                $em->flush();
            }
        }

        if(!$trick->getImages()->isEmpty() || !$trick->getVideos()->isEmpty())
        {
            $templateBuilder = $this->get('template.builder');

            if(!$trick->getImages()->isEmpty())
            {
                $images = $trick->getImages();
                foreach($images as $image)
                {
                    $files[]  = $image;
                }
            }
            else
            {
                $files = null;
            }
            if(!$trick->getVideos()->isEmpty())
            {
                $videos = $trick->getVideos();
                foreach($videos as $video)
                {
                    $urls[]  = $video;
                }
            }
            else
            {
                $urls = null;
            }

            $carousel = $templateBuilder->displayMedias($files, $urls, 4);
        }
        else
        {
            $carousel = null;
        }

        $content = $this->renderView('@P6Platform/Platform/trick.html.twig', array(
            'trick'=> $trick,
            'carousel' => $carousel,
            'form' => $form->createView()
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
            'trick' => $trick
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
            if(!$images->isEmpty())
            {
                $fileUploader = $this->get('image.uploader');

                foreach ($images as $image)
                {
                    $name = $fileUploader->upload($image->getFIle());
                    $image->setTrick($trick);
                    $image->setFile($name);
                }
            }

            $videos = $form['videos']->getNormData();

            if(!$videos->isEmpty())
            {
                $IDBuilder = $this->get('IDBuilder');

                foreach ($videos as $video)
                {
                    $link = $IDBuilder->extractID($video->getUrl());
                    $video->setTrick($trick);
                    $video->setUrl($link);
                }
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
    public function deleteTrickAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository('P6PlatformBundle:Trick')->find($id);

        $em->remove($trick);
        $em->flush();

        return new Response($this->redirectToRoute('p6_homepage'));
    }

    /**
     * @param $type
     * @param $id
     * @Route ("deleteMedia/{type}/{id}", name="p6_deleteMedia")
     * @return Response
     */
    public function deleteMediaAction($type, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if($type == 'image')
        {
            $image = $em->getRepository('P6PlatformBundle:Image')->find($id);
            $imageEraser = $this->get('delete.image');
            $imageEraser->delete($image->getFile());
            $trick = $image->getTrick()->getId();
            $em->remove($image);
        }

        if($type == 'video')
        {
            $video = $em->getRepository('P6PlatformBundle:Video')->find($id);
            $trick = $video->getTrick();
            $em->remove($video);
        }

        $em->flush();

        $content = $this->redirectToRoute('p6_onetrick', array(
            'id' => $trick
        ));

        return new Response($content);
    }

    /**
     * @param $type
     * @param $id
     * @Route ("updateMedia/{type}/{id}", name="p6_updateMedia")
     */
    public function updateMediaAction($type, $id)
    {
        var_dump($type);
    }

}


