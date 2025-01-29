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
date_default_timezone_set('Europe/Paris');

class CharacterController extends AbstractController
{
    #[Route('characters', name: 'app_characters')]
    public function index(CharacterRepository $characterRepository): JsonResponse
    {
        $data = $characterRepository->findAll();
        return $this->json($data,200,[],["groups"=>['character','character_personalities']]
    );
    }

    #[Route('characters/{id}', name: 'app_characters_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Character $character): JsonResponse
    {
        if (!$character) {
            return $this->json([
                "fail" =>["this character doesn't exist"]],Response::HTTP_NOT_FOUND);  
            }
        return $this->json($character, Response::HTTP_OK,[],["groups"=>['character','character_personalities']] 
    );
    }


    #[Route('characters/create', name: 'app_characters_create', methods: ['POST'])]
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
        return $this->json($character, Response::HTTP_CREATED, ["Location" => $this->generateUrl("app_characters")], 
       );
    }

    #[Route('/characters/delete/{id}', name: 'app_characters_delete', methods: ['DELETE'], requirements: ['id' => '\d+'])]
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

    #[Route('characters/edit/{id}', name: 'app_characters_edit', methods: ['GET'])]
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


    #[Route('characters/update/{id}', name:"app_characters_update", methods:['PUT'])]
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
        return $this->json($updatedCharacter, Response::HTTP_CREATED,["Location" => $this->generateUrl("app_characters")],["groups"=>['characterLinked']]);
   }

   #[Route('characters/{nickname}', name: 'app_characters_name', methods: ['GET'], requirements: ['nickname' => '[a-zA-Z]+'])]
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

