<?php
/**
 * Created by PhpStorm.
 * User: heilop
 * Date: 2019-04-16
 * Time: 19:59
 */

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
  public function homepage(ArticleRepository $repository) {
    $articles = $repository->findAllPublishedOrderedByNewest();
    return $this->render('article/homepage.html.twig', [
      'articles' => $articles,
    ]);
  }

  /**
   * @Route("/news/{slug}", name="show_article")
   */
  public function showArticle(Article $article) {
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
  public function toggleHeartArticle(Article $article, LoggerInterface $logger, EntityManagerInterface $em) {
    // @TODO - actually heart/unheart the article!
    $article->incrementHeartCount();
    $em->flush();

    $logger->info('Article is being hearted!.');

    return new JsonResponse(['hearts' => $article->getHeartCount()]);
  }
}