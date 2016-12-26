<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use BlogBundle\Entity\PostComment;
use BlogBundle\Entity\PostRepository;
use BlogBundle\Entity\User;
use BlogBundle\Exception\AccessDeniedWithRouteException;
use BlogBundle\Form\commentType;
use BlogBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function homeAction()
    {

      //$mem=new \Memcache();
      //if(!$mem->connect("127.0.0.1",11211)){
      //  die('连接失败!');
      //} else {
      //  dump($mem);
      //}

      /**
       * @var $user User
       */
      $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $blogList = $em->getRepository('BlogBundle:Post')->findAll();
        return $this->render('@Blog/blog/home.html.twig', [
            'blog_list' => $blogList
        ]);
    }

    public function postListAction(Request $request)
    {
        $searchStr = $request->query->get('s', '');
        $page = $request->query->get('page', 1);
        $limitPerPage = 4;

        $em = $this->getDoctrine()->getManager();
        
        if ($searchStr) {
            ///**
            // * @var $repository PostRepository
            // */
            //$repository = $em->getRepository('BlogBundle:Post');
            //$query = $repository->createQueryBuilder("p")
            //  ->where("p.id>3")
            //  ->getQuery();
            //
            //$blogList = $query->getResult();

            $blogList = $em->getRepository('BlogBundle:Post')->searchPostByTitle($searchStr);
                
        } else {
            //$blogList = $em->getRepository('BlogBundle:Post')->findAll();

            $dql   = "SELECT p FROM BlogBundle:Post p ORDER BY p.id DESC";
            $query = $em->createQuery($dql);

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
              $query, /* query NOT result */
              $page,
              $limitPerPage/*limit per page*/
            );

        }
        //dump($pagination);

        return $this->render('@Blog/blog/post.html.twig', [
          'searchStr' => $searchStr,
          'pagination' => $pagination,
        ]);
    }

    public function postDetailAction($id, Request $request)
    {

        $id = (int)$id;
        if (empty($id)) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository("BlogBundle:Post")->findOneBy( ['id' => $id] );

        if (!$blog) {
            throw $this->createNotFoundException();
        }

        $comment = new PostComment();
        $form = $this->createForm(commentType::class, $comment, []);

        $form->handleRequest($request);
        if($form->isValid()){
          $postData = $request->request->get('comment');

          if (!empty($postData['reply_to'])) {
            $referrer = $em->getRepository('BlogBundle:PostComment')->find($postData['reply_to']);
            if ($referrer) {
              $depth = $referrer->getDepth();
              $comment->setDepth($depth + 1);
              $comment->setReferrer($referrer);
            }

          }
          $comment->setUser($this->getUser());
          $comment->setPost($blog);
          $em->persist($comment);
          $em->flush($comment);

          $this->addFlash('notice', 'comment success!');
          return $this->redirectToRoute('blog_post_detail', ['id' => $id]);

        }

        return $this->render("@Blog/blog/post_detail.html.twig", [
          'blog' => $blog,
          'form' => $form->createView()
        ]);

    }


	/**
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
   */
    public function postNewAction(Request $request)
    {

        //$this->denyAccessUnlessGranted("ROLE_USER");
      if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          dump(1);
      } else {
        dump(2);
      }

       if (!$this->isGranted("ROLE_USER") || !$this->isGranted('IS_AUTHENTICATED_FULLY')) {
           $currentRoute = $request->attributes->get('_route');
           throw new AccessDeniedWithRouteException('', null, $currentRoute);
       }


        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();


        $post = new Post();
        $form = $this->createForm(PostType::class, $post, []);

        $form->handleRequest($request);
        if ($form->isValid()) {

            /**
             * @var $file UploadedFile
             */
            //$file = $request->files->get('post')['img'];
            //dump($request->files->get('img'));
            //dump($request->request->get('post'));

            /*
            $file = $post->getThumbnail();
            dump($file);

            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
              $this->getParameter('post_upload_directory'). '/' .date("Ymd") ,
              $fileName
            );

            $post->setThumbnail($fileName);*/

            $post->setUser($user);
            $em->persist($post);
            $em->flush($post);

            return $this->redirectToRoute('blog_post_list');
        }

        return $this->render('@Blog/blog/post_new.html.twig', [
            'form' => $form->createView()
        ]);
        
        
        
    }

    public function contactAction()
    {
        return $this->render("@Blog/blog/contact.html.twig");
    }
    
    
    
    
    public function indexAction()
    {
        return $this->render('BlogBundle:Default:index.html.twig');
    }

    public function testAction()
    {
        return $this->render('@Blog/Default/new_try.html.twig');
    }

    public function dataAction()
    {
        $data = array(
            [
                "type"=>"cm-normal",
                "content"=> "5中堌协 畸地 喖地轩 村楞枯枯 在",
                "time" => "11:29",
                "date" => "4-5",
            ],
            [
              "type"=>"cm-comment",
              "content"=> "6让我们一起相约6月25日高招咨询会直播吧！",
              "time" => "11:44",
              "date" => "4-8",
               "comment" => [
                   [
                       "auth"=>"jjj",
                       'time'=> '8465',
                        "content" => "cccccccccc",
                   ],
               ]
            ],
            [
              "type"=>"cm-comment",
              "content"=> "7让我们一起相约6月25",
              "time" => "00:00",
              "date" => "4-0",
              "comment" => [
                [
                  "auth"=>"jjj",
                  'time'=> '8465',
                  "content" => "cccccccccc",
                ],
                [
                  "auth"=>"qqqq",
                  'time'=> '8465',
                  "content" => "xxxxxxxxxxxxxxxx",
                ],
              ]
            ],
        );
        return new JsonResponse($data);
    }

  public function counterAction()
  {
    return $this->render('BlogBundle:Default:countdown.html.twig');
    }
}
