<?php 

namespace App\Model;

use App\Enum\TransportType;
use App\Enum\SeatReference;
use App\Enum\FlightClass;

class Reservation
{
    public function __construct(
        public ?TransportType $transportType = null,
        public ?FlightClass $flightClass = null,
        public ?SeatReference $seatReference = null,
        public ?bool $isRoundTrip = null,
        public ?\DateTimeImmutable $departureDate = null,
        public ?\DateTimeImmutable $returnDate = null,
    ) {
    }
}