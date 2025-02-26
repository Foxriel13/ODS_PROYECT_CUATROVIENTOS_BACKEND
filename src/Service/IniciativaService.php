<?php

namespace App\Services;

use App\Repository\RecipeRepository;
use App\Entity\CURSOS;
use App\Entity\DIMENSION;
use App\Entity\ENTIDADESEXTERNAS;
use App\Entity\ENTIDADESEXTERNASINICIATIVAS;
use App\Entity\INICIATIVAS;
use App\Entity\INICIATIVASMODULOS;
use App\Entity\METAS;
use App\Entity\METASINICIATIVAS;
use App\Entity\MODULOS;
use App\Entity\ODS;
use App\Entity\PROFESORES;
use App\Entity\PROFESORESINICIATIVAS;
use App\Entity\PROFESORESMODULOS;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IniciativaService
{
    private INICIATIVARepository $iniciativaRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, INICIATIVARepository $iniciativaRepository)
    {
        $this->entityManager = $entityManager;
        $this->iniciativaRepository = $iniciativaRepository;
    }

    public function getInciativas(): JsonResponse
    {
        $iniciativas = $this->iniciativaRepository->findAll();

        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No iniciatives found'], Response::HTTP_NOT_FOUND);
        }

        $data = array_map(fn($iniciativa) => $this->formatIniciativa($iniciativa), $iniciativas);

        return new JsonResponse($data);
        
    }
    private function formatIniciativa($iniciativa): array
    {
        return [
            'id' => $iniciativa->getId(),
            'accion' => $iniciativa->getAccion(),
            'horas' => $iniciativa->getHoras(),
            'nombre' => $iniciativa->getNombre(),
            'horas' => $iniciativa->getProductoFinal(),
            'accion' => $iniciativa->getFechaInicio()->format('Y-m-d H:i:s'),
            'horas' => $iniciativa->getFechaFin()->format('Y-m-d H:i:s'),
            
        ];
    }

    
    public function createRecipe(array $data): JsonResponse
    {
        if (!isset($data['title'], $data['number-diner'], $data['ingredients'], $data['steps'])) {
            return new JsonResponse(['message' => 'Invalid request data'], Response::HTTP_BAD_REQUEST);
        }

        $recipe = new Recipe();
        $recipe->setTitle($data['title']);
        $recipe->setNComensales($data['number-diner']);

        // Agregar ingredientes
        foreach ($data['ingredients'] as $ingredientData) {
            if (!isset($ingredientData['name'], $ingredientData['quantity'], $ingredientData['unit'])) {
                continue;
            }

            $ingredient = new Ingredient();
            $ingredient->setName($ingredientData['name']);
            $ingredient->setQuantity($ingredientData['quantity']);
            $ingredient->setUnit($ingredientData['unit']);
            $ingredient->setRecipe($recipe);

            $this->entityManager->persist($ingredient);
        }

        // Agregar pasos
        foreach ($data['steps'] as $stepData) {
            if (!isset($stepData['order'], $stepData['description'])) {
                continue;
            }

            $step = new Step();
            $step->setNStep($stepData['order']);
            $step->setDescription($stepData['description']);
            $step->setRecipe($recipe);

            $this->entityManager->persist($step);
        }
        foreach ($data['nutrients'] as $nutrientData) {
            if (!isset($nutrientData['type-id'], $nutrientData['quantity'])) {
                continue;
            }

            $nutrientType = $this->entityManager->getRepository(NutrientType::class)->find($nutrientData['type-id']);

            if ($nutrientType) {
                $nutrient = new Nutrient();
                $nutrient->setNutrientType($nutrientType);
                $this->entityManager->persist($nutrient);

                $recipeNutrient = new RecipeNutrient();
                $recipeNutrient->setRecipe($recipe);
                $recipeNutrient->setNutrient($nutrient);
                $recipeNutrient->setCantidad($nutrientData['quantity']);

                $this->entityManager->persist($recipeNutrient);
            }
        }

        // Guardar en la BD
        $this->entityManager->persist($recipe);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Recipe created successfully'], Response::HTTP_CREATED);
    }
}