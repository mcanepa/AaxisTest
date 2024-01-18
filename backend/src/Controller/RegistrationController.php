<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

#[Route("/api", name: "api_")]
class RegistrationController extends AbstractController
{
	#[Route("/registration", name: "user_registration", methods: "post")]
	public function index(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
	{
		$em = $doctrine->getManager();

		$body = json_decode($request->getContent());

		$email = $body->email;

		$plaintextPassword = $body->password;

		$user = $doctrine->getRepository(User::class)->findOneBy(["email" => $email]);

		if(empty($user))
		{
			$user = new User();

			$hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);

			$user->setPassword($hashedPassword);
			$user->setEmail($email);

			$em->persist($user);
			$em->flush();

			return $this->json(["message" => "Usuario creado!"]);
		}
		else
		{
			return $this->json(["message" => "El usuario ya existe"], 400);
		}
	}
}
