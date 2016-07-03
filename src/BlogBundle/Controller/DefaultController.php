<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
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
