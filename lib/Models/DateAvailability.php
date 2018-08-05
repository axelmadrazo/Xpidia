<?php
/*
 * DateAvailability
 */
namespace \Models;

/*
 * DateAvailability
 */
class DateAvailability {
    /* @var \DateTime $localDate  */
    private $localDate;
/* @var string $status &#x60;Available&#x60;: The offer is available on this date. &#x60;Unavailable&#x60;: The offer does not run on this date. &#x60;SoldOut&#x60;: The offer is sold out on this date. &#x60;SpecifiedConfigurationUnavailable&#x60;: The requested configuration is not available for this offer on this date. &#x60;SpecifiedConfigurationNotAllowed&#x60;: The requested configuration is never allowed for this offer.  */
    private $status;
/* @var string $availabilityType  */
    private $availabilityType;
/* @var string $accuracy  */
    private $accuracy;
/* @var int $availableCapacity  */
    private $availableCapacity;
/* @var int $maximumCapacity  */
    private $maximumCapacity;
}
