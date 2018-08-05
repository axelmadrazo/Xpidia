<?php
/*
 * TicketTypeCount
 */
namespace \Models;

/*
 * TicketTypeCount
 */
class TicketTypeCount {
    /* @var string $partnerTicketTypeId  */
    private $partnerTicketTypeId;
/* @var int $travelerCount Represents the number of travelers for the booking. This is the same as the now deprecated &#x60;count&#x60; property. */
    private $travelerCount;
/* @var int $voucherCount Represents the number of vouchers for the booking. This will usually be the same as &#x60;travelerCount&#x60; but will be different if the volume-based pricing is per-group pricing. */
    private $voucherCount;
}
