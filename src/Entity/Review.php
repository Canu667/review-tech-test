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
 *         "hotel",
 *         "text",
 *         "createdAt",
 *         "score"
 *     }
 * )
 */
class Review
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
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Hotel")
     * @ORM\JoinColumn(name="hotelId", referencedColumnName="id")
     * @Groups({"rest"})
     * @OA\Property(ref="#/components/schemas/Hotel")
     */
    private $hotel;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"rest"})
     * @OA\Property(
     *     type="string",
     * )
     */
    private $text;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Groups({"rest"})
     * @OA\Property(
     *     type="string",
     * )
     */
    protected $createdAt;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Groups({"rest"})
     * @OA\Property(
     *     type="integer",
     * )
     */
    private $score;

    public function __construct(UuidInterface $id = null)
    {
        $this->id = $id;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    public function setHotel(Hotel $hotel): self
    {
        $this->hotel = $hotel;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }


    public function setText($text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore($score): self
    {
        $this->score = $score;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
