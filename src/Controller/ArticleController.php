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

  /**
   * @Route("/news/{slug}")
   */
  public function showArticle($slug) {
    return new Response(sprintf(
      'Future page to show the article: %s',
      $slug
    ));
  }
}