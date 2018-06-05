<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Grass;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Users;





class MenuController extends Controller
{
    /**
     * @Route("/menu",name="menu")
     */
    public function render_menu(EntityManagerInterface $em,Request $request)
    {
        $blogPosts = $em->getRepository('AppBundle:Grass')->findAll();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->render('user/menu.html.twig', [
            'blog_posts' => $blogPosts,
            'full_title' => 'Администратор',
            'short_title' => 'АДМ',
            'current_user' => $user,
            'created' => $user->getCreated(),
            'status' => 'Онлайн',
            'action' => $request->get('action'),
        ]);
    }
}
