<?php

namespace SimoMarcGoebel\Blog\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SimoMarcGoebel\Blog\Road\Road;

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
        $carsOnRoad = $road->getCars();

        return $this->renderer->handle($request, 'road.twig', [
            'cars' => $carsOnRoad,
        ]);
    }
}