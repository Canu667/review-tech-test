<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Info(title="Hotel API", version="1.0.0")
 */
class ApiController
{
    /**
     * @Route("/openapi.json", methods={"GET"})
     */
    public function openApiJson(): JsonResponse
    {
        $openapi = \OpenApi\scan(__DIR__. '/..');
        $json = $openapi->toJson();

        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }
}
