<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{

    private $entityManager;

    /**
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/compte/modifier-mot-de-passe", name="account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;
        //je récupère le user actif en session
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        //fonction handlerequest qui 'écoute' le formulaire et vérifie si il est rempli ou pas
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on récupère l'ancien mot de passe à travers le formulaire
            $old_pwd = $form->get('old_password')->getData();

            //on vérifie si le mot de passe actuel est correct grâce à l'encoder
            if ($encoder->isPasswordValid($user, $old_pwd)){
                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user, $new_pwd);

                $user->setPassword($password);
//                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = "Votre mot de passe à bien été mis à jour.";
            } else {
                $notification = "Votre mot de passe actuel n'est pas le bon.";
            }
        }



        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notif' => $notification
        ]);
    }
}
