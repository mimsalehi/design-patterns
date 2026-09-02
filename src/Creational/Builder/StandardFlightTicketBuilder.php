<?php

declare(strict_types=1);

namespace App\Creational\Builder;

use InvalidArgumentException;

class StandardFlightTicketBuilder implements FlightTicketBuilderInterface
{
    private FlightTicket $ticket;
    private bool $hasFlightDetails = false;
    private bool $hasPassengerDetails = false;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): self
    {
        $this->ticket = new FlightTicket();
        $this->hasFlightDetails = false;
        $this->hasPassengerDetails = false;

        return $this;
    }

    public function setFlight(string $flightNumber, string $origin, string $destination, string $departureDate): self
    {
        $this->ticket->setFlightDetails($flightNumber, $origin, $destination, $departureDate);
        $this->hasFlightDetails = true;

        return $this;
    }

    public function setPassenger(string $passengerName, string $nationalId): self
    {
        $this->ticket->setPassengerDetails($passengerName, $nationalId);
        $this->hasPassengerDetails = true;

        return $this;
    }

    public function setSeatClass(string $seatClass): self
    {
        $this->ticket->setSeatClass($seatClass);

        return $this;
    }

    public function addExtraBaggage(int $weightKg): self
    {
        if ($weightKg < 0 || $weightKg > 50) {
            throw new InvalidArgumentException("Extra baggage must be between 0 and 50 kg.");
        }

        $this->ticket->setExtraBaggageKg($weightKg);

        return $this;
    }

    public function withTravelInsurance(): self
    {
        $this->ticket->setHasTravelInsurance(true);

        return $this;
    }

    public function withCipLounge(): self
    {
        $this->ticket->setHasCipLounge(true);

        return $this;
    }

    public function withSpecialMeal(string $mealType): self
    {
        $this->ticket->setSpecialMeal($mealType);

        return $this;
    }

    public function selectSeat(string $seatNumber): self
    {
        $this->ticket->setSeatNumber($seatNumber);

        return $this;
    }

    public function build(): FlightTicket
    {
        if (!$this->hasFlightDetails) {
            throw new InvalidArgumentException("Cannot build flight ticket: Flight details are required.");
        }

        if (!$this->hasPassengerDetails) {
            throw new InvalidArgumentException("Cannot build flight ticket: Passenger details are required.");
        }

        $result = $this->ticket;
        // Auto reset for the next build
        $this->reset();

        return $result;
    }
}
