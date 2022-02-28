<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\NFT;
use App\Entity\User;
use App\Form\ModifierType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class ProfileController extends AbstractController
{
    // public function __toString()
    // {
    //     return (string) ;
    // }
    #[Route('/profile', name: 'profile')]
    public function index(Request $req, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $email = $this->getUser()->getEmail();
        $nft =$doctrine->getRepository(NFT::class)->findByEmail($email);
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user'=>$user,
            'nft'=>$nft,
        ]);
    }

    #[Route('/profile/settings', name: 'settings')]
    public function settings(Request $req, ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher,EntityManagerInterface $entityManager): Response
    {
        // $em = $doctrine->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ModifierType::class, $user, [
            'action' => $this->generateUrl('settings'),
            'method' => 'POST',
        ]);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $username = $form->get('username')->getData();
            $pasword = $form->get('password')->getData();
            $bio = $form->get('bio')->getData();
            $facebook = $form->get('facebook')->getData();
            $twitter = $form->get('twitter')->getData();
            $discord = $form->get('discord')->getData();
            $image = $form->get('photo')->getData();
            $couverture = $form->get('couverture')->getData();

            if($pasword != $user->getPassword()){
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $pasword
                    )
                );
                

            }
            $dir =  $this->getParameter('photos');
            if ($image) {
                //$originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                //$safeFilename = $slugger->slug($originalFilename);
                $newFilename =  uniqid() . '.' . $image->guessExtension();
                //supprimer l'ancienne image de l'user du serveur si elle existe
                if($user->getPhoto()){
                    try{
                        unlink($dir . '/' . $user->getPhoto());
                    }catch (\Exception $e){
                    }
                }
                // ajouetr la nouvelle image : Move the file to the directory where images are stored
                try {
                    $image->move(
                        $dir,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $user->setPhoto($newFilename);
            }

            $dir1 =  $this->getParameter('couverture');


              if ($couverture) {
           
                  $newFilenameCov =  uniqid() . '.' . $couverture->guessExtension();
            // //     //supprimer l'ancienne image de l'user du serveur si elle existe
                 if($user->getCouverture()){
                    try{
                        unlink($dir . '/' . $user->getCouverture());
                    }
            catch (\Exception $e){
                     }
                 }
            // //     // ajouetr la nouvelle image : Move the file to the directory where images are stored
                try {
                    $couverture->move(
                        $dir1,
                         $newFilenameCov
                    );
                 } catch (FileException $e) {
                    
                 }
                  $user->setCouverture($newFilenameCov);
             }



            $user->setBio($bio);
            $user->setUsername($username);
            $user->setFacebook($facebook);
            $user->setTwitter($twitter);
            $user->setDiscord($discord);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('profile');
        
        }


        return $this->render('profile/settings.html.twig', [
            'controller_name' => 'ProfileController',
            'user'=>$user,
            'form' => $form->createView(),
            
        ]);
    }

    #[Route('/view/{id}', name: 'profile_view')]
    public function ViewUser(Request $req, ManagerRegistry $doctrine,User $user): Response
    {
        
        $email = $user->getEmail();
        $nft =$doctrine->getRepository(NFT::class)->findByEmail($email);
        return $this->render('profile/ViewProfil.html.twig', [
            'controller_name' => 'ProfileController',
            'user'=>$user,
            'nft'=>$nft,
        ]);
    }
}
