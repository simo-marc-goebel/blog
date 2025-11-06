<?php

namespace SimoMarcGoebel\Blog\Speed;

interface Speed{
    public function getSpeed();
    public function setSpeed(int $speed): void;
}