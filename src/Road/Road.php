<?php
namespace SimoMarcGoebel\Blog\Road;
use SimoMarcGoebel\Blog\Car\Car;

class Road
{
    public array $cars;
    function __construct()
    {
        $this->buildRoad();
    }
    function buildRoad() : void
    {
        $sedan = new Car(80, "red", "Sedan");
        $sport = new Car(180, "silver", "Sport");
        $pickup = new Car(120, "Black", "Pickup");

        $this->cars = [$sedan, $sport, $pickup];
    }

    /**
     * @return array<Car> Returns all cars on the road
     */
    public function getCars() : array
    {
        return $this->cars;
    }
}