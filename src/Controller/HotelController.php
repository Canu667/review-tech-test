<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Hotel;
use App\Repository\HotelRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;

class HotelController extends AbstractController
{
    const DECIMAL_NUMBER = 2;

    /**
     * @var ReviewRepository
     */
    private $reviewRepository;

    /**
     * @var HotelRepository
     */
    private $hotelRepository;

    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(
        ReviewRepository $reviewRepository,
        HotelRepository $hotelRepository,
        SerializerInterface $serializer
    ) {
        $this->reviewRepository = $reviewRepository;
        $this->hotelRepository  = $hotelRepository;
        $this->serializer       = $serializer;
    }

    /**
     * @OA\Get(
     *     operationId="hotel_reviews",
     *     description="Gets all the reviews for a hotel",
     *     tags={"Hotel"},
     *     path="/api/v1/hotels/{id}/reviews",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The UUID of the hotel",
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
     *          @OA\Items(ref="#/components/schemas/Review")
     *      )
     *     ),
     *   )
     * )
     *
     * @Route("/api/v1/hotels/{id}/reviews", name="review_list", methods={"GET"})
     * @param Hotel $hotel
     *
     * @return Response
     */
    public function getReviews(Hotel $hotel): JsonResponse
    {
        $reviews = $this->reviewRepository->findBy([
            'hotel' => $hotel->getId()->toString(),
        ]);

        return new JsonResponse(
            $this->serializer->serialize(
                $reviews,
                'json',
                [
                    'ignored_attributes' => ['hotel'],
                    'groups' => ['rest']
                ]
            ),
            Response::HTTP_OK, [],
            true
        );
    }

    /**
     * @OA\Get(
     *     operationId="hotels_list",
     *     description="Gets all the hotels",
     *     tags={"Hotel"},
     *     path="/api/v1/hotels",
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
     * @Route("/api/v1/hotels", name="hotel_list", methods={"GET"})
     */
    public function getHotels(): JsonResponse
    {
        $data = $this->serializer->serialize(
            $this->hotelRepository->findAll(),
            'json',
            ['groups' => ['rest']]
        );

        return new JsonResponse(
            $data, Response::HTTP_OK, [], true
        );
    }
}
