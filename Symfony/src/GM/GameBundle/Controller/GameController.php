<?php

namespace GM\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GM\GameBundle\Entity\Comment;
use GM\GameBundle\Form\CommentType;

class GameController extends Controller
{
    public function indexAction()
    {

        $arrayList = $this->getDoctrine()
            ->getManager()
            ->getRepository('GMGameBundle:Game')
            ->myFindAll()
        ;

        return $this->render('GMGameBundle:Game:index.html.twig', array(
            'list' => $arrayList,
        ));

    }

    public function viewAction($id, Request $request)
    {
        $game = $this->getDoctrine()
            ->getManager()
            ->getRepository('GMGameBundle:Game')
            ->finByID($id)
        ;

        // if (null === $game) {
        //     throw new NotFoundHttpException("The games with ID  " . $id . " not Found.");
        // }

        // Récupération de la liste des commenatiaire
        // $listApplications = $em
        //     ->getRepository('OCPlatformBundle:Application')
        //     ->findBy(array('advert' => $advert))
        // ;

        // Récupération des AdvertSkill de l'annonce
        // $listAdvertSkills = $em
        //     ->getRepository('OCPlatformBundle:AdvertSkill')
        //     ->findBy(array('advert' => $advert))
        // ;
        $comment = new Comment;
        $url = 0;
  
        $form = $this->get('form.factory')->create(CommentType::class, $comment);

        if ($request->isMethod('POST') ) {

            $comment->setGame($game[0]);
            $comment->setUser($this->getUser());

            $url = $comment;

            // $em = $this->getDoctrine()->getManager();

           
            
         

            
            // $comment->setGame($game[0]);
            // $comment->setUser($this->getUser());

            // $url = $comment;

            // $em->persist($comment);

           

            // $em->flush();

            // $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');


            

           

        }   

        

        return $this->render('GMGameBundle:Game:view.html.twig', array(
            'game' => $game[0],
            'url' => $url,
            'form' => $form->createView(),

        ));
    }
}
