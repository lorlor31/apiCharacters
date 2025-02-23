<?php

namespace App\Controller;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

date_default_timezone_set('Europe/Paris');

class CharacterController extends AbstractController
{
    #[Route('characters', name: 'api_characters')]
    public function index(CharacterRepository $characterRepository,LoggerInterface $logger): JsonResponse
    {
        $logger->info('I just got the logger');

        $data = $characterRepository->findAll();
        return $this->json($data,200,[],["groups"=>['character','character_personalities']]
    );
    }

    #[Route('characters/{id}', name: 'api_characters_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Character $character): JsonResponse
    {
        if (!$character) {
            return $this->json([
                "fail" =>["this character doesn't exist"]],Response::HTTP_NOT_FOUND);  
            }
        return $this->json($character, Response::HTTP_OK,[],["groups"=>['character','character_personalities']] 
    );
    }
    
/* CAS AVEC json
    #[Route('characters/create', name: 'api_characters_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = $request->getContent();
        try {
            $character = $serializer->deserialize($data, Character::class, 'json');
        } catch (NotEncodableValueException $exception) {
            return $this->json([
                "error" =>
                ["message" => $exception->getMessage()]
            ], Response::HTTP_BAD_REQUEST);
        }

        // Validation
        $errors = $validator->validate($character);
        if (count($errors) > 0) {
            $dataErrors = [];
            foreach ($errors as $error) {
            $dataErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(["error" => ["message" => $dataErrors]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $entityManager->persist($character);
        $entityManager->flush();
        return $this->json($character, Response::HTTP_CREATED, ["Location" => $this->generateUrl("api_characters")], 
       );
    } */
// src/Controller/CharacterController.php


    #[Route('characters/create', name: 'api_characters_create', methods: ['POST'])]
    public function create(Request $request, CharacterRepository $characterRepository,
    SerializerInterface $serializer, EntityManagerInterface $entityManager, 
    ValidatorInterface $validator,LoggerInterface $logger): Response
    {
        $character = new Character();
        // Récupérer les données envoyées via FormData (non JSON)
        $nickname = $request->get('nickname');
        $abstract = $request->get('abstract');
        $longDescription = $request->get('long_description');
        $birthDate = $request->get('birthDate');
        $deathDate = $request->get('deathDate');

        //Pour le fichier de l'avatar
        $avatarImage = $request->files->get('avatar_image');
        if ($avatarImage) {
            if (!$avatarImage instanceof UploadedFile) {
                $logger->error('Aucun fichier reçu.');
                return $this->json(['error' => 'Pas d\'upload'], 400);
            }
            $uploadsDir = $this->getParameter('kernel.project_dir') . '/public/uploads/images/avatars';
            // S'assurer que le dossier existe
            $filesystem = new Filesystem();
            if (!$filesystem->exists($uploadsDir)) {
            $filesystem->mkdir($uploadsDir, 0777);
            }
            // Générer un nom unique
            $newFilename = uniqid() . '.' . $avatarImage->guessExtension();
            // Copier le fichier dans $uploadsDir
            try {
                $avatarImage->move($uploadsDir, $newFilename);
            } catch (\Exception $e) {
                $logger->error('Erreur lors du déplacement du fichier : ' . $e->getMessage());
                return $this->json(['error' => 'File upload failed'], 500);
            }
        }


        // Set les données dans l'entité
        $character->setNickname($nickname);
        $character->setAbstract($abstract);
        $character->setLongDescription($longDescription);
        $character->setBirthDate(new \DateTime($birthDate));
        $avatarImage ? $character->setAvatarImage($newFilename) : null;
        $deathDate ? $character->setDeathDate(new \DateTime($deathDate)) : null;

        // Validation
        $errors = $validator->validate($character);
        if (count($errors) > 0) {
            $dataErrors = [];
            foreach ($errors as $error) {
            $dataErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            $logger->critical('donnees envoyees', ['donnees' => $character]); // Recommandé
            $logger->critical('erreurs de validation', ['erreurs' => $dataErrors]); // Recommandé
            return $this->json(["error" => ["message" => $dataErrors]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        // Sauvegarde de l'entité dans la base de données
        $entityManager->persist($character);
        $entityManager->flush();

        return $this->json([
            'message' => 'Personnage créé avec succès',
            'data' => $character,
        ], Response::HTTP_OK);
    }












    

    #[Route('/characters/delete/{id}', name: 'api_characters_delete', methods: ['DELETE'], requirements: ['id' => '\d+'])]
    public function delete(CharacterRepository $characterrepos,$id,EntityManagerInterface $em): JsonResponse
    {
            $character=$characterrepos->find($id);
            if (empty($character)){
                return $this->json([
                    "error"=>"There aren't any character  with this id !"
                ]
                , Response::HTTP_BAD_REQUEST);
            }
            try {
                $em->remove($character);
                $em->flush();
                return $this->json([
                    "success" =>"Item deleted with success !"
                ],
                Response::HTTP_OK);
            }
            catch(\Exception $e){
                return $this->json([
                    "error"=>"We encounter some errors with your deletion",
                    "reason"=>$e->getMessage()
                ]
                , Response::HTTP_INTERNAL_SERVER_ERROR);
            }
    }

    #[Route('characters/edit/{id}', name: 'api_characters_edit', methods: ['GET'])]
    public function edit(Character $character): JsonResponse
    {
        if (!$character) {
            return $this->json([
                "fail" => ["this character doesn't exist"]
            ], Response::HTTP_NOT_FOUND);
        }
        return $this->json(
            $character, 
            Response::HTTP_OK, 
            [], 
        
        );
    }


    #[Route('characters/update/{id}', name:"api_characters_update", methods:['PUT'])]
    public function update(Request $request, SerializerInterface $serializer, Character $currentCharacter, EntityManagerInterface $em,ValidatorInterface $validator,CharacterRepository $characterRepository): JsonResponse 
    {   
        if (!$currentCharacter) {
            return $this->json([
                "fail" =>["this character doesn't exist"]],Response::HTTP_NOT_FOUND);  
            }
        try {
            $updatedCharacter = $serializer->deserialize($request->getContent(),
                Character::class, 
                'json', 
                [AbstractNormalizer::OBJECT_TO_POPULATE => $currentCharacter]);
        }catch (NotEncodableValueException $exception) {
            return $this->json([
                "error" =>
                ["message" => $exception->getMessage()]
            ], Response::HTTP_BAD_REQUEST);
        }
        $errors = $validator->validate($updatedCharacter);
        if (count($errors) > 0) {
            $dataErrors = [];            
            foreach ($errors as $error) {    
            $dataErrors[$error->getPropertyPath()] = $error->getMessage();
            }

        }
        $em->persist($updatedCharacter);
        $em->flush();
        return $this->json($updatedCharacter, Response::HTTP_CREATED,["Location" => $this->generateUrl("api_characters")],["groups"=>['characterLinked']]);
   }

   #[Route('characters/{nickname}', name: 'api_characters_name', methods: ['GET'], requirements: ['nickname' => '[a-zA-Z]+'])]
   public function findByName(CharacterRepository $characterRepository,$nickname): JsonResponse
   {
       $data = $characterRepository->findByNickname($nickname);

       return $this->json(
           $data, 
           Response::HTTP_OK, 
           [], 
           
       );
   }


}

