<?php

namespace SimoMarcGoebel\Blog\Vehicle;

use SimoMarcGoebel\Blog\Color\Color;
use SimoMarcGoebel\Blog\Speed\Speed;
use SimoMarcGoebel\Blog\Title\Title;

class Vehicle implements Title, Color, Speed
{

    private int $speed;
    private string $color;
    private string $title;


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
}