<?php

namespace App\DataFixtures;

use App\Entity\Hotel;
use App\Entity\HotelChain;
use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Ramsey\Uuid\Uuid;

class AppFixtures extends Fixture
{
    private $hotelChains = [
        [
            'uuid' => '2a964bb8-58c9-4c4d-9ca5-b4234b4329dc',
            'name' => 'Blockchain',
        ],
    ];

    private $hotelsData = [
        [
            'uuid'    => '1f451fb2-8ee5-4716-8ba2-dc308f6d842e',
            'reviews' => [
                [
                    'uuid' => '16972d64-cb8d-4484-81f9-4ec39969b1da',
                    'score'   => 10,
                    'comment' => 'Very nice stay',
                    'date' => '2018-01-14T15:03:01.012345Z'
                ],
                [
                    'uuid' => '4da7ed1b-4def-42ef-bd56-5b62b0a5ed05',
                    'score'   => 5,
                    'comment' => 'Average',
                    'date' => '2019-09-14T15:03:01.012345Z'
                ],
                [
                    'uuid' => '590a960c-6fe7-456c-83be-71e19690637e',
                    'score'   => 9,
                    'comment' => 'Very nice stay, I enjoyed it a lot.',
                    'date' => '2019-09-14T15:03:01.012345Z'
                ],
                [
                    'uuid' => 'f2c5db4c-d497-4b7e-adbd-35fe538ad31a',
                    'score'   => 1,
                    'comment' => 'Worst experience ever.',
                    'date' => '2019-09-14T15:03:01.012345Z'
                ],
            ],
        ],
        [
            'uuid'      => '3c848009-8172-4373-9635-0c3153601ba6',
            'chainUuid' => '2a964bb8-58c9-4c4d-9ca5-b4234b4329dc',
            'reviews'   => [
                [
                    'uuid' => 'b595e54e-c5f8-4d0b-a0d2-29ab877a0ce0',
                    'score'   => 10,
                    'comment' => 'Very nice stay, the reception was really fast.',
                    'date' => '2019-01-01T15:03:01.012345Z'
                ],
                [
                    'uuid' => '33f6eaf5-c1f5-4cd2-b4a7-ace1d53b0865',
                    'score'   => 5,
                    'comment' => 'The receptionist was not smiling.',
                    'date' => '2019-01-01T15:03:01.012345Z'
                ],
            ],
        ],
        [
            'uuid' => '35d4e77c-562f-4bbc-a30e-ba5099021b3d',
        ],
        [
            'uuid' => 'b8e17d2e-3229-499a-a87d-8594198c46ad',
        ],
        [
            'uuid' => 'e45428c5-7cd7-4ae8-ab06-5535030d0933',
            'chainUuid' => '2a964bb8-58c9-4c4d-9ca5-b4234b4329dc',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ([HotelChain::class, Hotel::class, Review::class] as $class) {
            $metadata = $manager->getClassMetadata($class);
            $metadata->setIdGenerator(new AssignedGenerator());
            $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_NONE);
        }

        foreach ($this->hotelChains as $hotelChainData) {
            $hotelChain = (new HotelChain(Uuid::fromString($hotelChainData['uuid'])))
                ->setName($hotelChainData['name']);

            $manager->persist($hotelChain);

            $this->addReference($hotelChainData['uuid'], $hotelChain);
        }

        foreach ($this->hotelsData as $hotelData) {
            $hotel = (new Hotel(Uuid::fromString($hotelData['uuid'])))
                ->setName('Hotel Alexanderplatz')
                ->setAddress('Alexanderplatz 1, 10409, Berlin')
                ->setHotelChain(
                    isset($hotelData['chainUuid']) ? $this->getReference($hotelData['chainUuid']) : null
                )
                ->setRooms(150);

            $manager->persist($hotel);

            if (isset($hotelData['reviews'])) {
                foreach ($hotelData['reviews'] as $reviewData) {
                    $review = (new Review(Uuid::fromString($reviewData['uuid'])))
                        ->setHotel($hotel)
                        ->setScore($reviewData['score'])
                        ->setCreatedAt(new \DateTime($reviewData['date']))
                        ->setText($reviewData['comment']);

                    $manager->persist($review);
                }
            }
        }

        $manager->flush();
    }
}
