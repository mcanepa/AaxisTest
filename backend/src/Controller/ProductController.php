<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;

#[Route("/api", name: "api_")]
class ProductController extends AbstractController
{
	#[Route("/products", name: "product_index", methods:["get"] )]
	public function index(ManagerRegistry $doctrine): JsonResponse
	{
		$products = $doctrine->getRepository(Product::class)->findAll();

		$response = [];

		foreach($products as $product)
		{
			$response[] = [
			   "id" => $product->getId(),
			   "sku" => $product->getSku(),
			   "name" => $product->getName(),
			   "description" => $product->getDescription(),
			   "created_at" => $product->getCreatedAt(),
			   "updated_at" => $product->getUpdatedAt(),
			];
		}

		return $this->json($response);
	}

	#[Route("/products", name: "product_create", methods:["post"] )]
	public function create(ManagerRegistry $doctrine, Request $request): JsonResponse
	{
		$entityManager = $doctrine->getManager();

		$response = [
			"items" => [],
			"errors" => []
		];

		$items = json_decode($request->getContent(), true);

		if(!empty($items))
		{
			$index = 0;

			foreach($items as $item)
			{
				$index++;

				if(empty(trim($item["sku"])))
				{
					$response["errors"][] = "No se ha especificado SKU para item {$index}";
				}
				else
				{
					$product = $doctrine->getRepository(Product::class)->findOneBy(["sku" => $item["sku"]]);

					if(empty($product))
					{
						if(empty(trim($item["name"])))
						{
							$response["errors"][] = "No se ha especificado el nombre para item {$index}";
						}
						else
						{
							$product = new Product();

							$product->setSku($item["sku"]);
							$product->setName($item["name"]);
							$product->setDescription($item["description"] ?? null);

							$entityManager->persist($product);

							$response["items"][] = [
								"id" => $product->getId(),
								"sku" => $product->getSku(),
								"name" => $product->getName(),
								"description" => $product->getDescription(),
								"created_at" => $product->getCreatedAt(),
								"updated_at" => $product->getUpdatedAt(),
							];
						}
					}
					else
					{
						$response["errors"][] = "Ya existe un producto con SKU {$item["sku"]} para item {$index}";
					}
				}
			}

			$entityManager->flush();
		}

		return $this->json($response);
	}

	#[Route("/products", name: "product_update", methods:["put"] )]
	public function update(ManagerRegistry $doctrine, Request $request): JsonResponse
	{
		$entityManager = $doctrine->getManager();

		$response = [
			"items" => [],
			"errors" => []
		];

		$items = json_decode($request->getContent(), true);

		if(!empty($items))
		{
			$index = 0;

			foreach($items as $item)
			{
				$index++;

				if(empty(trim($item["sku"])))
				{
					$response["errors"][] = "No se ha especificado SKU para item {$index}";
				}
				else
				{
					$product = $doctrine->getRepository(Product::class)->findOneBy(["sku" => $item["sku"]]);

					if(empty($product))
					{
						$response["errors"][] = "No existe un producto con SKU {$item["sku"]} para item {$index}";
					}
					else
					{
						$product->setName($item["name"] ?? $product->getName());
						$product->setDescription($item["description"] ?? $product->getDescription());

						$entityManager->persist($product);

						$response["items"][] = [
							"id" => $product->getId(),
							"sku" => $product->getSku(),
							"name" => $product->getName(),
							"description" => $product->getDescription(),
							"created_at" => $product->getCreatedAt(),
							"updated_at" => $product->getUpdatedAt(),
						];
					}
				}
			}

			$entityManager->flush();
		}

		return $this->json($response);
	}
}
