<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Hotel;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;

class ReviewController extends AbstractController
{
    const DECIMAL_NUMBER = 2;

    /**
     * @var ReviewRepository
     */
    private $reviewRepository;

    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(
        ReviewRepository $reviewRepository,
        SerializerInterface $serializer
    ) {
        $this->reviewRepository = $reviewRepository;
        $this->serializer       = $serializer;
    }

    /**
     * @OA\Get(
     *     operationId="reviews_average",
     *     description="Gets the average score of reviews for a hotel",
     *     tags={"Reviews", "Average"},
     *     path="/api/v1/reviews/{id}/average",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The UUID of the hotel",
     *         required=true,
     *         @OA\Schema(
     *             type="UUID"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="since",
     *         in="query",
     *         description="The date since the average should be calculated",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Returns the response",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(
     *              property="avg",
     *              description="The average of reviews for a hotel. This is decimal.",
     *              type="string",
     *          ),
     *      )
     *     ),
     *   )
     * )
     *
     * @Route("/api/v1/reviews/{id}/average", name="average", methods={"GET"})
     * @param Hotel $hotel
     *
     * @return JsonResponse
     */
    public function getAverage(Hotel $hotel, Request $request): Response
    {
        $sinceDate = $request->get('since');

        return new JsonResponse(
            [
                'avg' => number_format(
                    $this->reviewRepository->getAverageForHotel($hotel->getId(), $sinceDate), self::DECIMAL_NUMBER
                ),
            ]
        );
    }
}
