<?php

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class BlogController extends AbstractController
{
	/**
	*@var Environment
	*@Route("/blog",name="blog")
	*@return Response
	*/
    public function index():Response
    {
		$repo = $this->getDoctrine()->getRepository(Article::class);
		$articles = $repo->findAll();
        return $this->render('blog/index.html.twig',[
		'controller_name' => 'BlogController',
		'articles' => $articles
		]);
    }
	
	/**
	*@var Environment
	*@Route("/",name="home")
	*/
    public function home()
    {
	return $this->render('blog/home.html.twig',['title' => " My Bloge Symfony 4"]);
    }
	
    /**
	*@Route("/blog/edit/comment/{id}", name = "comment_edit")
	*/
    public function comment_edit($id, Request $request)
    {
			$comment = $this->getDoctrine()->getRepository(Comment::class)
		                                       ->find($id);
			
			
			$article =	$comment->getArticle();	
			$form = $this->createFormBuilder($comment)
			             ->add('author')
						 ->add('content')
						 ->getForm();
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			
			$comment->setCreatedAt(new \DateTime());
			
		$em = $this->getDoctrine()->getManager();
        $em->persist($comment);
		$em->flush();
		
		return $this->redirectToRoute('blog_show',['id' => $article->getId()]);
		}
		       
        return $this->render('blog/comment.html.twig',[
		'formArticle' => $form->createView(),
		'comment' => $comment
		]);
    }	

	/**
	*@Route("/admin/delete/comment/{id}",name="comment_delete")
	*/
    public function comment_delete($id)
    {
		  $comment = $this->getDoctrine()->getRepository(Comment::class)
		                                       ->find($id);
		 $article =	$comment->getArticle();							
			if($comment){
				$em = $this->getDoctrine()->getManager();
				$em->remove($comment);
				$em->flush();
			}
		
		return $this->redirectToRoute('blog_show',['id' => $article->getId()]);
    }	
	
    /**
	*@Route("/blog/new",name="blog_new")
	*@Route("/blog/{id}/edit",name="blog_edit")
	*/
    public function create(Article $article=null, Request $request)
    {
		   
			if(!$article){
			$article = new Article();
			$article->setTitle("The Title for the article");
			$article->setContent("The content for the article");
			$article->setImage("Enter the Url for the image");
			}
			
			$form = $this->createFormBuilder($article)
			             ->add('title')
						 ->add('content')
						 ->add('image')
						 ->getForm();
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			if(!$article->getId()){
			$article->setCreatedAt(new \DateTime());
			}
		$em = $this->getDoctrine()->getManager();
        $em->persist($article);
		$em->flush();
		
		return $this->redirectToRoute('blog_show',['id' => $article->getId()]);
				
        }
        return $this->render('blog/create.html.twig',[
		'formArticle' => $form->createView(),
		'editMode' => $article->getId()!== null
		]);
    }
	
	/**
	*@Route("/admin/{id}/delete",name="blog_delete")
	*/
    public function delete($id, Request $request)
    {
	    $article = $this->getDoctrine()->getRepository(Article::class)
		                                       ->find($id);
			if($article){
				$em = $this->getDoctrine()->getManager();
				$em->remove($article);
				$em->flush();
			}
		
		return $this->redirectToRoute('blog');
		
    }
	
	/**
	*@var Environment
	*@Route("/blog/{id}",name="blog_show")
	*@return Response
	*/
    public function show($id, Request $request)
    {
		$repo = $this->getDoctrine()->getRepository(Article::class);
		$article = $repo->find($id);
		
		
		    $comment = new Comment();
			$comment->setAuthor("The Name of Author ");
			$comment->setContent("The content of the Comment");
			$article = $this->getDoctrine()->getRepository(Article::class)
		                                       ->find($id);
				    if(!$article){}
		
			
			$form = $this->createFormBuilder($comment)
			             ->add('author')
						 ->add('content')
						 ->getForm();
			$form->handleRequest($request);
			if($form->isSubmitted() && $form->isValid()){

					$comment->setCreatedAt(new \DateTime());
					$comment->setArticle($article);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($comment);
			$em->flush();
		return $this->redirectToRoute('blog_show',['id' => $article->getId()]);
			}
		
		
        return $this->render('blog/show.html.twig',[
		'article' => $article,
		'formComment' => $form->createView(),
		]);
    }
}