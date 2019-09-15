<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity
 * @OA\Schema(
 *     description="Hotel information entity.",
 *     required={
 *         "id",
 *         "name",
 *         "address",
 *         "rooms"
 *     }
 * )
 */
class Hotel
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
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     * @Groups({"rest"})
     * @OA\Property(
     *     type="string",
     * )
     */
    protected $address;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"rest"})
     * @OA\Property(
     *     type="integer",
     * )
     */
    protected $rooms;

    /**
     * @ORM\ManyToOne(targetEntity="HotelChain")
     * @ORM\JoinColumn(name="hotelChainId", referencedColumnName="id", nullable=true)
     * @Groups({"rest"})
     * @OA\Property(ref="#/components/schemas/HotelChain")
     */
    private $hotelChain;

    public function __construct(UuidInterface $id = null)
    {
        $this->id = $id;
    }

    public function getId()
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

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress($address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getRooms(): int
    {
        return $this->rooms;
    }

    public function setRooms($rooms): self
    {
        $this->rooms = $rooms;
        return $this;
    }

    public function getHotelChain(): ?HotelChain
    {
        return $this->hotelChain;
    }

    public function setHotelChain($hotelChain): self
    {
        $this->hotelChain = $hotelChain;

        return $this;
    }
}
