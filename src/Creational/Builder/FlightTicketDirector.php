<?php

declare(strict_types=1);

namespace App\Creational\Builder;

class FlightTicketDirector
{
    /**
     * Builds a standard economy ticket without paid add-ons.
     */
    public function buildStandardEconomyTicket(
        FlightTicketBuilderInterface $builder,
        string $flightNumber,
        string $origin,
        string $destination,
        string $departureDate,
        string $passengerName,
        string $nationalId
    ): FlightTicket {
        return $builder->reset()
            ->setFlight($flightNumber, $origin, $destination, $departureDate)
            ->setPassenger($passengerName, $nationalId)
            ->setSeatClass('ECONOMY')
            ->build();
    }

    /**
     * Builds an economy ticket with travel insurance and 10kg baggage.
     */
    public function buildEconomyComfortPackage(
        FlightTicketBuilderInterface $builder,
        string $flightNumber,
        string $origin,
        string $destination,
        string $departureDate,
        string $passengerName,
        string $nationalId,
        string $seatNumber
    ): FlightTicket {
        return $builder->reset()
            ->setFlight($flightNumber, $origin, $destination, $departureDate)
            ->setPassenger($passengerName, $nationalId)
            ->setSeatClass('ECONOMY')
            ->addExtraBaggage(10)
            ->withTravelInsurance()
            ->selectSeat($seatNumber)
            ->build();
    }

    /**
     * Builds a premium VIP Business ticket with CIP airport lounge, meal, and 30kg extra luggage.
     */
    public function buildVipBusinessPackage(
        FlightTicketBuilderInterface $builder,
        string $flightNumber,
        string $origin,
        string $destination,
        string $departureDate,
        string $passengerName,
        string $nationalId,
        string $seatNumber,
        string $specialMeal
    ): FlightTicket {
        return $builder->reset()
            ->setFlight($flightNumber, $origin, $destination, $departureDate)
            ->setPassenger($passengerName, $nationalId)
            ->setSeatClass('BUSINESS')
            ->addExtraBaggage(30)
            ->withTravelInsurance()
            ->withCipLounge()
            ->selectSeat($seatNumber)
            ->withSpecialMeal($specialMeal)
            ->build();
    }
}
