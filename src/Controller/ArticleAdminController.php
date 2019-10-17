<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;

/**
 * @IsGranted("ROLE_ADMIN_ARTICLE")
 */
class ArticleAdminController extends AbstractController
{

  /**
   * @Route("/admin/article/new", name="admin_article_new")
   */
  public function new(EntityManagerInterface $em) {
    // @TODO Create admin page.
    die('@Todo');

    return new Response(sprintf('
      Hey Yeah, New Article id: #%d slug:%s',
      $article->getId(),
      $article->getSlug()
    ));
  }

  /**
   * @Route("/article/admin", name="article_admin")
   */
  public function index() {
      return $this->render('article_admin/index.html.twig', [
          'controller_name' => 'ArticleAdminController',
      ]);
  }
}
