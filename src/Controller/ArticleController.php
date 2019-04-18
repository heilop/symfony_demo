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
   * @Route("/", name="homepage")
   */
  public function homepage() {
    return $this->render('article/homepage.html.twig');
  }

  /**
   * @Route("/news/{slug}", name="show_article")
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
      'slug' => $slug,
      ]
    );
  }
}