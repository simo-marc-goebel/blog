<?php

namespace SimoMarcGoebel\Blog\RoadObjects;

interface Speed{
    public function getSpeed();
    public function setSpeed(int $speed): void;
}