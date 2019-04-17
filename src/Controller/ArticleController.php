<?php
/**
 * Created by PhpStorm.
 * User: heilop
 * Date: 2019-04-16
 * Time: 19:59
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController {

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
    $comments = [
      'This is the first comment!',
      'This is the second comment!',
      'This is the third comment!',
    ];

    return $this->render('article/show-article.html.twig', [
      'title' => ucwords(str_replace('-', ' ', $slug)),
      'comments' => $comments,
      ]
    );
  }
}