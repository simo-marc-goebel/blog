<?php

namespace SimoMarcGoebel\Blog\Road;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SimoMarcGoebel\Blog\Handler\RenderHandler;

class RoadHandler
{
    private RenderHandler $renderer;

    public function __construct()
    {
        $this->renderer = new RenderHandler("Road");
    }
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $road = new Road();
        $carsOnRoad = $road->getVehicles();

        return $this->renderer->handle($request, 'road.twig', [
            'cars' => $carsOnRoad,
        ]);
    }
}