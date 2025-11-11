<?php

namespace SimoMarcGoebel\Blog\RoadObjects\Vehicle;

use SimoMarcGoebel\Blog\RoadObjects\Color;
use SimoMarcGoebel\Blog\RoadObjects\Speed;
use SimoMarcGoebel\Blog\RoadObjects\Title;

class Vehicle implements Title, Color, Speed
{

    private int $speed;
    private string $color;
    private string $title;

    public function __construct(int $speed, string $color, string $title){
        $this->setSpeed($speed);
        $this->setColor($color);
        $this->setTitle($title);
    }

    public function getTitle(): string {
        return $this->title;
    }
    public function setTitle(string $title): void {
        $this->title = $title;
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
        return false;
    }
}