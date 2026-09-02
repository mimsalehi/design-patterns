<?php

declare(strict_types=1);

namespace App\Tests;

use App\Creational\Builder\FlightTicketDirector;
use App\Creational\Builder\StandardFlightTicketBuilder;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    private StandardFlightTicketBuilder $builder;
    private FlightTicketDirector $director;

    protected function setUp(): void
    {
        $this->builder = new StandardFlightTicketBuilder();
        $this->director = new FlightTicketDirector();
    }

    public function testFluentBuilderConstructsCustomTicketWithAddons(): void
    {
        $ticket = $this->builder
            ->setFlight('W5-1044', 'THR', 'KIH', '2026-09-22 14:00')
            ->setPassenger('Masoud Salehi', '0019283741')
            ->setSeatClass('BUSINESS')
            ->addExtraBaggage(25)
            ->withTravelInsurance()
            ->withCipLounge()
            ->withSpecialMeal('Vegetarian')
            ->selectSeat('1B')
            ->build();

        $this->assertSame('W5-1044', $ticket->getFlightNumber());
        $this->assertSame('THR', $ticket->getOrigin());
        $this->assertSame('KIH', $ticket->getDestination());
        $this->assertSame('Masoud Salehi', $ticket->getPassengerName());
        $this->assertSame('0019283741', $ticket->getNationalId());
        $this->assertSame('BUSINESS', $ticket->getSeatClass());
        $this->assertSame(25, $ticket->getExtraBaggageKg());
        $this->assertTrue($ticket->hasTravelInsurance());
        $this->assertTrue($ticket->hasCipLounge());
        $this->assertSame('Vegetarian', $ticket->getSpecialMeal());
        $this->assertSame('1B', $ticket->getSeatNumber());
    }

    public function testDirectorBuildsStandardEconomyTicket(): void
    {
        $ticket = $this->director->buildStandardEconomyTicket(
            $this->builder,
            'IR-420',
            'THR',
            'SYZ',
            '2026-09-25 10:15',
            'Sara Mohammadi',
            '0078923412'
        );

        $this->assertSame('IR-420', $ticket->getFlightNumber());
        $this->assertSame('ECONOMY', $ticket->getSeatClass());
        $this->assertSame(0, $ticket->getExtraBaggageKg());
        $this->assertFalse($ticket->hasTravelInsurance());
        $this->assertFalse($ticket->hasCipLounge());
        $this->assertNull($ticket->getSpecialMeal());
        $this->assertNull($ticket->getSeatNumber());
    }

    public function testDirectorBuildsVipBusinessPackageWithAllAddons(): void
    {
        $ticket = $this->director->buildVipBusinessPackage(
            $this->builder,
            'W5-1044',
            'THR',
            'MHD',
            '2026-09-28 19:30',
            'Dr. Kaveh Rad',
            '0034182910',
            '2A',
            'Diabetic Meal'
        );

        $this->assertSame('BUSINESS', $ticket->getSeatClass());
        $this->assertSame(30, $ticket->getExtraBaggageKg());
        $this->assertTrue($ticket->hasTravelInsurance());
        $this->assertTrue($ticket->hasCipLounge());
        $this->assertSame('2A', $ticket->getSeatNumber());
        $this->assertSame('Diabetic Meal', $ticket->getSpecialMeal());
    }

    public function testBuilderThrowsExceptionWhenFlightDetailsMissing(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot build flight ticket: Flight details are required.');

        $this->builder
            ->setPassenger('Masoud Salehi', '0019283741')
            ->build();
    }

    public function testBuilderThrowsExceptionWhenPassengerDetailsMissing(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot build flight ticket: Passenger details are required.');

        $this->builder
            ->setFlight('W5-1044', 'THR', 'KIH', '2026-09-22 14:00')
            ->build();
    }

    public function testBuilderThrowsExceptionOnInvalidBaggageWeight(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Extra baggage must be between 0 and 50 kg.');

        $this->builder->addExtraBaggage(55);
    }

    public function testBuilderResetAllowsMultipleIndependentBuilds(): void
    {
        $ticket1 = $this->builder
            ->setFlight('FL-1', 'THR', 'MHD', '2026-09-20')
            ->setPassenger('User One', '111')
            ->withTravelInsurance()
            ->build();

        $ticket2 = $this->builder
            ->setFlight('FL-2', 'THR', 'TBZ', '2026-09-21')
            ->setPassenger('User Two', '222')
            ->build();

        $this->assertTrue($ticket1->hasTravelInsurance());
        $this->assertFalse($ticket2->hasTravelInsurance());
        $this->assertSame('FL-1', $ticket1->getFlightNumber());
        $this->assertSame('FL-2', $ticket2->getFlightNumber());
    }
}
