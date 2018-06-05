<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Applicants;
use AppBundle\Entity\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        return $this->redirect("/admin/users");
    }

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function admin_usersAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->render('/admin/users.html.twig', array(
            'full_title' => 'Администратор',
            'short_title' => 'АДМ',
            'current_user' => $user,
            'created' => $user->getCreated(),
            'status' => 'Онлайн',
            'users' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Users')->findAll(),
            'roles' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Role')->findAll(), 
            'departments' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Department')->findAll(),
            'action' => $request->get('action'),
        ));
    }

    /**
     * @Route("/admin/users/add", name="add_user")
     * @Method({"GET"})
     */
    public function add_userAction()
    {
        $current_user = $this->get('security.token_storage')->getToken()->getUser();
        $roles = $this->getDoctrine()->getRepository('AppBundle:Role')->findAll();
        $departments = $this->getDoctrine()->getRepository('AppBundle:Department')->findAll();
        $choices = array();
        $choices2 = array();

        foreach ($roles as $role)
        {
            $choices[$role->getName()] = $role->getRole();
        }
        foreach ($departments as $department)
        {
            $choices2[$department->getDepartment()] = $department->getId();
        }

        $add_user = new Users();
        $form = $this->createFormBuilder($add_user)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('fio', TextType::class)
            ->add('phone', TextType::class)
            ->add('role', ChoiceType::class, array('choices' => $choices, 'data' => 'ROLE_USER' ))
            ->add('department', ChoiceType::class, array('choices' => $choices2, 'data' => '' ))
            ->add('submit', SubmitType::class)
            ->getForm();

        return $this->render('/admin/user.html.twig', array(
            'full_title' => 'Администратор',
            'short_title' => 'АДМ',
            'current_user' => $current_user,
            'status' => 'Онлайн',
            'edit_user' => $add_user,
            'task_name' => 'Пользователь',
            'task_description' => 'новый пользователь',
            'role' => $this->getDoctrine()->getRepository('AppBundle:Role')->findAll(),
            'department' => $this->getDoctrine()->getRepository('AppBundle:Department')->findAll(),
            'form' => $form->createView(),
            'edit' => false
        ));
    }

    /**
     * @Route("/admin/users/add", name="new_user")
     * @Method({"POST"})
     */
    public function new_userAction(Request $request)
    {
        $roles = $this->getDoctrine()->getRepository('AppBundle:Role')->findAll();
        $departments = $this->getDoctrine()->getRepository('AppBundle:Department')->findAll();
        $choices = array();
        $choices2 = array();

        foreach ($roles as $role)
        {
            $choices[$role->getName()] = $role->getRole();
        }
        foreach ($departments as $department)
        {
            $choices2[$department->getDepartment()] = $department->getId();
        }

        $new_user = new Users();
        $form = $this->createFormBuilder($new_user)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('fio', TextType::class)
            ->add('phone', TextType::class)
            ->add('role', ChoiceType::class, array('choices' => $choices, 'data' => $new_user->getRole()))
            ->add('department', ChoiceType::class, array('choices' => $choices2, 'data' => $new_user->getDepartment()))
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now=new \DateTime('NOW');
            $new_user->setRole($this->getDoctrine()->getRepository('AppBundle:Role')->find($new_user->getRole()));
            $new_user->setDepartment($this->getDoctrine()->getRepository('AppBundle:Department')->find($new_user->getDepartment()));
            $new_user->setPassword(md5($new_user->getPassword()));
            $new_user->setCreated($now);
            
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($new_user);
            $em->flush();

            return $this->redirectToRoute('user_success');
        }
        return $this->redirect('/admin/users');
        
        return new Response(var_dump($new_user));
    }

    /**
     * @Route("/admin/users/{id}", name="edit_user")
     * @ParamConverter("edit_user", class="AppBundle:Users")
     * @Method({"GET"})
     */
    public function edit_userAction(Users $edit_user)
    {
        $current_user = $this->get('security.token_storage')->getToken()->getUser();
        $roles = $this->getDoctrine()->getRepository('AppBundle:Role')->findAll();
        $departments = $this->getDoctrine()->getRepository('AppBundle:Department')->findAll();
        $choices = array();
        $choices2 = array();

        foreach ($roles as $role)
        {
            $choices[$role->getName()] = $role->getRole();
        }
        foreach ($departments as $department)
        {
            $choices2[$department->getDepartment()] = $department->getId();
        }

        $form = $this->createFormBuilder($edit_user)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class, array('required' => false))
            ->add('fio', TextType::class)
            ->add('phone', TextType::class)
            ->add('role', ChoiceType::class, array('choices' => $choices, 'data' => $edit_user->getRole() ))
            ->add('department', ChoiceType::class, array('choices' => $choices2, 'data' => $edit_user->getDepartment() ))
            ->add('submit', SubmitType::class)
            ->getForm();

        return $this->render('/admin/user.html.twig', array(
            'full_title' => 'Администратор',
            'short_title' => 'АДМ',
            'current_user' => $current_user,
            'status' => 'Онлайн',
            'edit_user' => $edit_user,
            'task_name' => 'Пользователь',
            'task_description' => 'редактирование профиля',
            'role' => $this->getDoctrine()->getRepository('AppBundle:Role')->findAll(),
            'department' => $this->getDoctrine()->getRepository('AppBundle:Department')->findAll(),
            'form' => $form->createView(),
            'edit' => true
        ));
    }

    /**
     * @Route("/admin/users/{id}", name="save_user")
     * @ParamConverter("edit_user", class="AppBundle:Users")
     * @Method({"POST"})
     */
    public function save_userAction(Users $edit_user, Request $request)
    {
        $current_user = $this->get('security.token_storage')->getToken()->getUser();
        $roles = $this->getDoctrine()->getRepository('AppBundle:Role')->findAll();
        $departments = $this->getDoctrine()->getRepository('AppBundle:Department')->findAll();
        $choices = array();
        $choices2 = array();

        foreach ($roles as $role)
        {
            $choices[$role->getName()] = $role->getRole();
        }
        foreach ($departments as $department)
        {
            $choices2[$department->getDepartment()] = $department->getId();
        }

        $form = $this->createFormBuilder($edit_user)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class, array('required' => false))
            ->add('fio', TextType::class)
            ->add('phone', TextType::class)
            ->add('role', ChoiceType::class, array('choices' => $choices, 'data' => $edit_user->getRole()))
            ->add('department', ChoiceType::class, array('choices' => $choices2, 'data' => $edit_user->getDepartment()))
            ->add('submit', SubmitType::class)
            ->getForm();

        $old_password = $edit_user->getPassword();
        $form->handleRequest($request);

        if ($edit_user->getPassword() == "")
            $edit_user->setPassword($old_password);
        else if ($edit_user->getPassword() != $old_password)
            $edit_user->setPassword(md5($edit_user->getPassword()));

        if ($edit_user->getId() == $current_user->getId())
            $edit_user->setRole($current_user->getRole());

        $edit_user->setRole($this->getDoctrine()->getRepository('AppBundle:Role')->find($edit_user->getRole()));

        if ($edit_user->getId() == $current_user->getId())
            $edit_user->setDepartment($current_user->getDepartment());

        $edit_user->setDepartment($this->getDoctrine()->getRepository('AppBundle:Department')->find($edit_user->getDepartment()));

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($edit_user);
            $em->flush();
            //return new Response(var_dump($edit_user));
            return $this->redirectToRoute('user_success');
        }
        //return new Response(var_dump($edit_user));
        return $this->redirect('/admin/users/' . $edit_user->getId());
    }

    /**
     * @Route("/admin/users/{id}/delete", name="delete_user")
     * @ParamConverter("delete_user", class="AppBundle:Users")
     * @Method({"GET"})
     */
    public function delete_userAction(Users $delete_user)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user->getId() == $delete_user->getId()) {

            return $this->redirect($this->generateUrl('user_nodelete', array('action' => 'nodelete')));
        }
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($delete_user);
        $em->flush();

        return $this->redirectToRoute('user_success');
    }



    
}