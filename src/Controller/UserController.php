<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;

use App\Entity\User;

class UserController extends AbstractController
{
    private $logger;
    private $em;

    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $em
    ) {
        $this->logger = $logger;
        $this->em = $em;
    }

    /**
     * @Route("/user", name="app_user", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }
  
    /**
     * @Route("/user", name="create_user", methods={"POST"})
     */
    public function createUser(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        isset($data['name'])? $user->setName($data['name']) : null;
        isset($data['email'])? $user->setEmail($data['email']) : null;
        isset($data['phone'])? $user->setPhone($data['phone']) : null;

        // $errors = $this->validator->validate($user);
        // if (count($errors)) {
        //     $errorsString = (string) $errors;
        //     return new Response($errorsString);
        // }

        $this->em->persist($user);
        $this->em->flush();

        return new JsonResponse(['message' => 'User created!',
                                 'name'=> $user->getName(),
                                 'email'=> $user->getEmail(),
                                 'phone'=> $user->getPhone()], 201);
    }

    
}
