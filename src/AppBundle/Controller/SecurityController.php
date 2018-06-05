<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        return $this->render('security/login.html.twig', array());
    }

    /**
     * @Route("/afterlogin", name="afterlogin")
     */
    public function afterloginAction()
    {
        $roles = $this->get('security.token_storage')->getToken()->getRoles();

        $rolesTab = array_map(function($role){
            return $role->getRole();
        }, $roles);
        if (in_array('ROLE_ADMIN', $rolesTab, true))
            return $this->redirect('/admin');
        else if (in_array('ROLE_SUPER_USER', $rolesTab, true)) 
            return $this->redirect('/list/2015');
        else if(in_array('ROLE_DOC_EMP', $rolesTab, true))
            return $this->redirect('/pie');
        else if(in_array('ROLE_DOC_LEAD', $rolesTab, true))
            return $this->redirect('/pie');
        else if(in_array('ROLE_STAT_EMP', $rolesTab, true))
            return $this->redirect('/kassirtable');
        else if(in_array('ROLE_STAT_LEAD', $rolesTab, true))
            return $this->redirect('/kassirtable');
        else {
            return $this->redirect('/login');
        }
    }
}