<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    /**
     * @Route("/add-user")
     */
    public function userAction(Request $request){
        //$session=$request->getSession();
        $user=new \AppBundle\Entity\User();
        $form=  $this->createFormBuilder($user)
                ->add("firstname","text")
                ->add("lastname","text")
                ->add("email","email")
                ->add("password","password")
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()){
            $user=$form->getData();
            $em=  $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("index");
        }
        return $this->render('default/user.twig',array("myform"=>$form->createView()));
    }
    /**
     * @Route("/home",name="index")
     */
    public function newsAction(){
        return $this->render('default/home.twig',array());
    }
    
    /**
     * @Route("/new-post")
     */
    public function newpostAction(Request $request){
        $post=new \AppBundle\Entity\Post();
        $form=  $this->createFormBuilder($post)
                ->add("title","text")
                ->add("content","textarea")
                ->add("picture","text")
                ->add("time","datetime")
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()){
            $post=$form->getData();
            $em=  $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
             return $this->redirectToRoute("news-post");
        }
        return $this->render('default/new-post.twig',array("form"=>$form->createView()));
    }
      /**
     * @Route("/news",name="news-post")
     */
    public function newspostAction(){
        return $this->render('default/home.twig',array());
    }
    
    /**
     * @Route("/show-news/{id}")
     */
    public function shoenewsAction($id){
        $post=  $this->getDoctrine()->getRepository("AppBundle:Post")->find($id);
        return $this->render('default/home.twig',array("post"=>$post));
        
    }
}
