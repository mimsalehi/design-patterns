<?php

declare(strict_types=1);

namespace App\Creational\Builder;

interface FlightTicketBuilderInterface
{
    public function reset(): self;

    public function setFlight(string $flightNumber, string $origin, string $destination, string $departureDate): self;

    public function setPassenger(string $passengerName, string $nationalId): self;

    public function setSeatClass(string $seatClass): self;

    public function addExtraBaggage(int $weightKg): self;

    public function withTravelInsurance(): self;

    public function withCipLounge(): self;

    public function withSpecialMeal(string $mealType): self;

    public function selectSeat(string $seatNumber): self;

    public function build(): FlightTicket;
}
