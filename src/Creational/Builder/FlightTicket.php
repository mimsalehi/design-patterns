<?php

declare(strict_types=1);

namespace App\Creational\Builder;

class FlightTicket
{
    private string $flightNumber;
    private string $origin;
    private string $destination;
    private string $departureDate;
    private string $passengerName;
    private string $nationalId;
    private string $seatClass = 'ECONOMY';
    private int $extraBaggageKg = 0;
    private bool $hasTravelInsurance = false;
    private bool $hasCipLounge = false;
    private ?string $specialMeal = null;
    private ?string $seatNumber = null;

    public function setFlightDetails(string $flightNumber, string $origin, string $destination, string $departureDate): void
    {
        $this->flightNumber = $flightNumber;
        $this->origin = $origin;
        $this->destination = $destination;
        $this->departureDate = $departureDate;
    }

    public function setPassengerDetails(string $passengerName, string $nationalId): void
    {
        $this->passengerName = $passengerName;
        $this->nationalId = $nationalId;
    }

    public function setSeatClass(string $seatClass): void
    {
        $this->seatClass = $seatClass;
    }

    public function setExtraBaggageKg(int $kg): void
    {
        $this->extraBaggageKg = $kg;
    }

    public function setHasTravelInsurance(bool $hasInsurance): void
    {
        $this->hasTravelInsurance = $hasInsurance;
    }

    public function setHasCipLounge(bool $hasCip): void
    {
        $this->hasCipLounge = $hasCip;
    }

    public function setSpecialMeal(?string $meal): void
    {
        $this->specialMeal = $meal;
    }

    public function setSeatNumber(?string $seat): void
    {
        $this->seatNumber = $seat;
    }

    public function getFlightNumber(): string
    {
        return $this->flightNumber;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    public function getDepartureDate(): string
    {
        return $this->departureDate;
    }

    public function getPassengerName(): string
    {
        return $this->passengerName;
    }

    public function getNationalId(): string
    {
        return $this->nationalId;
    }

    public function getSeatClass(): string
    {
        return $this->seatClass;
    }

    public function getExtraBaggageKg(): int
    {
        return $this->extraBaggageKg;
    }

    public function hasTravelInsurance(): bool
    {
        return $this->hasTravelInsurance;
    }

    public function hasCipLounge(): bool
    {
        return $this->hasCipLounge;
    }

    public function getSpecialMeal(): ?string
    {
        return $this->specialMeal;
    }

    public function getSeatNumber(): ?string
    {
        return $this->seatNumber;
    }

    public function getSummary(): string
    {
        $services = [];
        if ($this->extraBaggageKg > 0) {
            $services[] = "Extra Baggage: {$this->extraBaggageKg}kg";
        }
        if ($this->hasTravelInsurance) {
            $services[] = "Travel Insurance: Included";
        }
        if ($this->hasCipLounge) {
            $services[] = "CIP Airport Lounge: Included";
        }
        if ($this->specialMeal !== null) {
            $services[] = "Meal: {$this->specialMeal}";
        }
        if ($this->seatNumber !== null) {
            $services[] = "Seat: {$this->seatNumber}";
        }

        $serviceList = count($services) > 0 ? implode(', ', $services) : 'No extra add-ons';

        return sprintf(
            "Ticket [%s] | Route: %s -> %s | Date: %s | Passenger: %s (%s) | Class: %s | Services: [%s]",
            $this->flightNumber,
            $this->origin,
            $this->destination,
            $this->departureDate,
            $this->passengerName,
            $this->nationalId,
            $this->seatClass,
            $serviceList
        );
    }
}
