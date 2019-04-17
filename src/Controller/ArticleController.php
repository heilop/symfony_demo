<?php
/**
 * Created by PhpStorm.
 * User: heilop
 * Date: 2019-04-16
 * Time: 19:59
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController {

  /**
   * @Route("/")
   */
  public function homepage() {
    return new Response('This will be the articles page!');
  }
}