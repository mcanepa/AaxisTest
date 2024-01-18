<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\UniqueConstraint(columns: ["sku"])]
class Product
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 50)]
	private ?string $sku = null;

	#[ORM\Column(length: 250)]
	private ?string $name = null;

	#[ORM\Column(type: Types::TEXT, nullable: true)]
	private ?string $description = null;

	#[ORM\Column]
	#[Gedmo\Timestampable(on:"create")]
	private ?\DateTimeImmutable $created_at = null;

	#[ORM\Column]
	#[Gedmo\Timestampable(on:"update")]
	private ?\DateTimeImmutable $updated_at = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getSku(): ?string
	{
		return $this->sku;
	}

	public function setSku(string $sku): static
	{
		$this->sku = $sku;

		return $this;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): static
	{
		$this->name = $name;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(?string $description): static
	{
		$this->description = $description;

		return $this;
	}

	public function getCreatedAt(): ?\DateTimeImmutable
	{
		return $this->created_at;
	}

	public function getUpdatedAt(): ?\DateTimeImmutable
	{
		return $this->updated_at;
	}
}
