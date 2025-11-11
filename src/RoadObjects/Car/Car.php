<?php

namespace SimoMarcGoebel\Blog\RoadObjects\Car;

use SimoMarcGoebel\Blog\RoadObjects\Color;
use SimoMarcGoebel\Blog\RoadObjects\Model;
use SimoMarcGoebel\Blog\RoadObjects\Speed;

class Car implements Color, Speed, Model
{
    private int $speed;
    private string $color;
    private string $model;

    public function __construct(int $speed, string $color, string $model){
        $this->setSpeed($speed);
        $this->setColor($color);
        $this->setModel($model);
    }
    public function getModel(): string {
        return $this->model;
    }
    public function setModel(string $model): void {
        $this->model = $model;
    }

    public function getColor(): string {
        return $this->color;
    }
    public function setColor(string $color): void {
        $this->color = $color;
    }

    public function getSpeed(): int {
        return $this->speed;
    }
    public function setSpeed(int $speed): void {
        $this->speed = $speed;
    }
    public function isCar(): bool {
        return true;
}
}