<?php
/**
 * Created by PhpStorm.
 * User: heilop
 * Date: 2019-04-16
 * Time: 19:59
 */

namespace App\Controller;


use App\Entity\Article;
use App\Service\MarkdownHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ArticleController extends AbstractController {

  /**
   * @var bool
   */
  private $isDebug;

  public function __construct(bool $isDebug) {

    $this->isDebug = $isDebug;
  }

  /**
   * @Route("/", name="homepage")
   */
  public function homepage() {
    return $this->render('article/homepage.html.twig');
  }

  /**
   * @Route("/news/{slug}", name="show_article")
   */
  public function showArticle($slug, MarkdownHelper $markdownHelper, EntityManagerInterface $em) {

    $repository = $em->getRepository(Article::class);
    $article = $repository->findOneBy(['slug' => $slug ]);


    if (!$article) {
      throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
    }

    $comments = [
      'This is the first comment!',
      'This is the second comment!',
      'This is the third comment!',
    ];


    // $articleContent = $markdownHelper->parse($articleContent);

    return $this->render('article/show-article.html.twig', [
        'article' => $article,
        'comments' => $comments,
      ]
    );
  }

  /**
   * @Route("news/{slug}/heart", name="toggle_article_heart", methods={"POST"});
   */
  public function toggleHeartArticle($slug) {
    // @TODO - actually heart/unheart the article!

    return new JsonResponse(['hearts' => rand(5, 100)]);
  }
}