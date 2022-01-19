<?php

namespace App\Controller;

use App\Entity\Generator;
use App\Service\GeneratorService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;

/**
 * @Route(
 *  "/api/generators",
 *  name="generators_"
 * )
 */
class GeneratorController extends AbstractController {
    public function __construct() {
    }

    /**
     * @Route(
     *  "/create",
     *  methods={"POST"},
     *  name="create"
     * )
     */
    public function create(Request $request, GeneratorService $service) {
        $data = json_decode(
            $request->getContent(),
            true
        );
        $generator = $service->create($data['generator_id'], $data['power']);

        return new JsonResponse($generator->toArray(), Response::HTTP_CREATED);
    }

    /**
     * @Route(
     *  "/{generator_id}",
     *  methods={"GET"},
     *  name="show"
     * )
     */
    public function show(Generator $generator, GeneratorService $service) {
        $generator = $service->getGeneratorData($generator);
        return new JsonResponse($generator);
    }

}
