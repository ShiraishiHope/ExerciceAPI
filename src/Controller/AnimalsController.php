<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/animals')]
class AnimalsController extends AbstractController
{
    #[Route('/', name: 'app_animals_index', methods: ['GET'])]
    public function index(AnimalRepository $animalRepository): JsonResponse
    {
        $animals = $animalRepository->findAll();

        return $this->json($animals, Response::HTTP_OK);
    }

    #[Route('/new', name: 'app_animals_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnimalRepository $animalRepository, EntityManagerInterface $manager): JsonResponse
    {
        $animalData = json_decode($request->getContent(), true);

        $animal = new Animal(
            $animalData['name'],
            $animalData['averageSize'],
            $animalData['country'],
            $animalData['martialArt'],
            $animalData['phoneNumber']
        );
        $manager->persist($animal);
        $manager->flush();

        return $this->json($animal, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_animals_show', methods: ['GET'])]
    public function show(Animal $animal): JsonResponse
    {
        return $this->json($animal, Response::HTTP_OK);
    }

    #[Route('/{id}/edit', name: 'app_animals_edit', methods: ['PUT', 'PATCH'])]
    public function edit(Request $request, Animal $animal, AnimalRepository $animalRepository, EntityManagerInterface $manager): JsonResponse
    {
        $animalData = json_decode($request->getContent(), true);
        $manager->persist($animal);
        $manager->flush();
        // Update the properties of the Animal entity if they exist in the payload
        if (isset($animalData['name'])) {
            $animal->setName($animalData['name']);
        }

        if (isset($animalData['averageSize'])) {
            $animal->setAverageSize($animalData['averageSize']);
        }

        if (isset($animalData['country'])) {
            $animal->setCountry($animalData['country']);
        }

        if (isset($animalData['martialArt'])) {
            $animal->setMartialArt($animalData['martialArt']);
        }

        if (isset($animalData['phoneNumber'])) {
            $animal->setPhoneNumber($animalData['phoneNumber']);
        }

        // Save the updated animal entity
        $animalRepository->save($animal, true);
        $manager->persist($animal);
        $manager->flush();
        return $this->json($animal, Response::HTTP_OK);
    }



    #[Route('/{id}', name: 'app_animals_delete', methods: ['DELETE'])]
    public function delete(Animal $animal, AnimalRepository $animalRepository): JsonResponse
    {
        $animalRepository->remove($animal, true);

        return $this->json(['success' => true], Response::HTTP_OK);
    }

}
