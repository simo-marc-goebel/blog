<?php
namespace SimoMarcGoebel\Blog\Road;
use SimoMarcGoebel\Blog\RoadObjects\Car\Car;
use SimoMarcGoebel\Blog\RoadObjects\Vehicle\Vehicle;

class Road
{
    public array $vehicles;
    function __construct()
    {
        $this->buildRoad();
    }
    function buildRoad() : void
    {
        $sedan = new Car(80, "red", "Sedan");
        $sport = new Car(180, "silver", "Sport");
        $pickup = new Car(120, "Black", "Pickup");
        $truck = new Vehicle(90, "white", "Semi");

        $this->vehicles = [$sedan, $sport, $pickup, $truck];
    }

    /**
     * @return array<Car> Returns all cars on the road
     */
    public function getVehicles() : array
    {
        return $this->vehicles;
    }
}