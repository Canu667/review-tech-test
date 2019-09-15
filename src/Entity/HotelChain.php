<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity
 * @OA\Schema(
 *     description="Hotel Chain information entity.",
 *     required={
 *         "id",
 *         "name"
 *     }
 * )
 */
class HotelChain
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(type="uuid")
     * @Groups({"rest"})
     * @OA\Property(
     *     type="UUID",
     * )
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Groups({"rest"})
     * @OA\Property(
     *     type="string",
     * )
     */
    protected $name;

    public function __construct(UuidInterface $id = null)
    {
        $this->id = $id;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }
}
