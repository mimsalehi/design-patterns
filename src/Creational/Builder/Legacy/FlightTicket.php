<?php

declare(strict_types=1);

namespace App\Creational\Builder\Legacy;

class FlightTicket
{
    /**
     * Anti-pattern: Telescoping constructor with 12 positional parameters.
     */
    public function __construct(
        private string $flightNumber,
        private string $origin,
        private string $destination,
        private string $departureDate,
        private string $passengerName,
        private string $nationalId,
        private string $seatClass = 'ECONOMY',
        private int $extraBaggageKg = 0,
        private bool $hasTravelInsurance = false,
        private bool $hasCipLounge = false,
        private ?string $specialMeal = null,
        private ?string $selectedSeatNumber = null,
    ) {
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
        if ($this->selectedSeatNumber !== null) {
            $services[] = "Seat: {$this->selectedSeatNumber}";
        }

        $serviceList = count($services) > 0 ? implode(', ', $services) : 'No extra add-ons';

        return sprintf(
            "Legacy Ticket [%s] | Route: %s -> %s | Date: %s | Passenger: %s (%s) | Class: %s | Add-ons: [%s]",
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
