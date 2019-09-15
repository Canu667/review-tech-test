<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\HotelChain;
use App\Repository\HotelChainRepository;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;

class HotelChainController extends AbstractController
{
    /**
     * @var HotelRepository
     */
    private $hotelRepository;

    /**
     * @var HotelChainRepository
     */
    private $hotelChainRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        HotelRepository $hotelRepository,
        HotelChainRepository $hotelChainRepository,
        SerializerInterface $serializer
    ) {
        $this->hotelRepository      = $hotelRepository;
        $this->hotelChainRepository = $hotelChainRepository;
        $this->serializer           = $serializer;
    }

    /**
     * @OA\Get(
     *     operationId="hotel_chain_list",
     *     description="Gets all the hotels in a chain",
     *     tags={"Chain"},
     *     path="/api/v1/chains/{id}/hotels",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The UUID of the chain of hotels",
     *         required=true,
     *         @OA\Schema(
     *             type="UUID"
     *         )
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Returns the response",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Hotel")
     *      )
     *     ),
     *   )
     * )
     *
     * @Route("/api/v1/chains/{id}/hotels", name="hotel_chain_list", methods={"GET"})
     * @param HotelChain $hotelChain
     *
     * @return JsonResponse
     */
    public function getHotels(HotelChain $hotelChain): JsonResponse
    {
        $hotels = $this->hotelRepository->findBy([
            'hotelChain' => $hotelChain->getId()->toString(),
        ]);

        return new JsonResponse(
            $this->serializer->serialize(
                $hotels,
                'json',
                [
                    'ignored_attributes' => ['hotelChain'],
                    'groups'             => ['rest'],
                ]
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @OA\Get(
     *     operationId="chains_list",
     *     description="Gets all the hotel chains",
     *     tags={"Chain"},
     *     path="/api/v1/chains",
     *     @OA\Response(
     *      response="200",
     *      description="Returns the response",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/HotelChain")
     *      )
     *     ),
     *   )
     * )
     *
     * @Route("/api/v1/chains", name="chains_list", methods={"GET"})
     */
    public function getAllHotelChains(): JsonResponse
    {
        $data = $this->serializer->serialize(
            $this->hotelChainRepository->findAll(),
            'json',
            ['groups' => ['rest']]
        );

        return new JsonResponse(
            $data, Response::HTTP_OK, [], true
        );
    }
}
