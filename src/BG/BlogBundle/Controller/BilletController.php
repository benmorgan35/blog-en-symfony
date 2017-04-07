<?php
//src/BG/BlogBundle/Controller/BilletController.php

namespace BG\BlogBundle\Controller;

// Le controller utilise l'objet Response défini avec use
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use BG\BlogBundle\Entity\Billet;
use BG\BlogBundle\Entity\Comment;
use BG\BlogBundle\Form\CommentType;
use BG\BlogBundle\Form\BilletType;
use BG\BlogBundle\Form\BilletEditType;

// Le nom du cobtroller respecte le nom du fichier pour l'autoload
class BilletController extends Controller
{

    public function indexAction()
    {

        $listBillets=$this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BGBlogBundle:Billet')
            ->findAll()
         ;

        //Récupérer la liste des épisodes et on la passe au template
        return $this->render('BGBlogBundle:Billet:index.html.twig', array('listBillets' => $listBillets
        ));

    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $billet = $em->getRepository('BGBlogBundle:Billet')->Find($id);
        if (null === $billet){
            throw new NotFoundHttpException("L'épisode d'id ".$id." n'existe pas.");
        }

        //On récupère les commentaires associés à cette annonce
        $listComments=$em
            ->getRepository('BGBlogBundle:Comment')
            ->findBy(array('billet' => $billet))
        ;

        return $this->render('BGBlogBundle:Billet:view.html.twig', array(
            'billet' => $billet,
            'listComments' => $listComments
        ));
    }

    public function addAction(Request $request)
    {
        $billet = new Billet();
        $form = $this->createForm(BilletType::class, $billet);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($billet);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Votre épisode a été publié');
            return $this->redirectToRoute('bg_blog_home');
        }
        return $this->render('BGBlogBundle:Billet:Add.html.twig', array(
            'form' =>$form->createView(),
        ));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $billet = $em->getRepository('BGBlogBundle:Billet')->find($id);

        if (null === $billet) {
            throw new NotFoundHttpException("L'épisode d'id " . $id . " n'existe pas.");
        }

        $form = $this->get('form.factory')->create(BilletEditType::class, $billet);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Episode modifié.');

            return $this->redirectToRoute('bg_blog_view', array('id' => $billet->getId()));
        }

        return $this->render('BGBlogBundle:Billet:edit.html.twig', array(
            'billet' => $billet,
            'form' => $form->createView(),
        ));
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $billet = $em->getRepository('BGBlogBundle:Billet')->find($id);

        if (null === $billet) {
            throw new NotFoundHttpException("L'épisode d'id ".$id." n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($billet);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', "L'épisode a été supprimé.");

            return $this->redirectToRoute('bg_blog_home');
        }

        return $this->render('BGBlogBundle:Billet:delete.html.twig', array(
            'billet' => $billet,
            'form'   => $form->createView(),
        ));
    }

    public function commentAddAction(Request $request, $billet)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        if ($request->isMethod('POST')&& $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Votre commentaire a été publié');
            return $this->redirectToRoute('bg_blog_view', array('id' => $billet->getId()));
        }
        return $this->render('BGBlogBundle:Billet:view.html.twig', array('form' =>$form->createView()
        ));
    }

    public function menuAction($limit)
    {
        $em = $this->getDoctrine()->getManager();

        $listBillets = $em->getRepository('BGBlogBundle:Billet')->findBy(
            array(),                 // Pas de critère
            array('date' => 'desc'), // On trie par date décroissante
            $limit,                  // On sélectionne $limit annonces
            0                        // À partir du premier
        );

        return $this->render('BGBlogBundle:Billet:menu.html.twig', array(
            'listBillets' => $listBillets
        ));
    }
}