<?php
/*
 * CreateSaleRequest
 */
namespace \Models;

/*
 * CreateSaleRequest
 */
class CreateSaleRequest {
    /* @var string $referenceId  */
    private $referenceId;
/* @var string $partnerActivityId  */
    private $partnerActivityId;
/* @var string $partnerOfferId  */
    private $partnerOfferId;
/* @var \DateTime $localDate  */
    private $localDate;
/* @var \\Models\TicketTypeCount[] $ticketTypes  */
    private $ticketTypes;
/* @var \\Models\Guest[] $guests  */
    private $guests;
/* @var \\Models\AdditionalCriteriaItem[] $additionalCriteria  */
    private $additionalCriteria;
/* @var int $holdDurationSeconds  */
    private $holdDurationSeconds;
}
