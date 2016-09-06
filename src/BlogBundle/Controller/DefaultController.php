<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $blogList = $em->getRepository('BlogBundle:Post')->findAll();
        return $this->render('@Blog/blog/home.html.twig', [
            'blog_list' => $blogList
        ]);
    }

    public function postListAction(Request $request)
    {
        $searchStr = $request->query->get('s', '');

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
            $blogList = $em->getRepository('BlogBundle:Post')->findAll();

        }

        return $this->render('@Blog/blog/post.html.twig', [
          'blog_list' => $blogList,
          'searchStr' => $searchStr,
        ]);
    }

    public function postDetailAction($id)
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

        return $this->render("@Blog/blog/post_detail.html.twig", [
          'blog' => $blog,
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
}
