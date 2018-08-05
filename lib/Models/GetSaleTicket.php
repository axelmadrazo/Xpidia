<?php
/*
 * GetSaleTicket
 */
namespace \Models;

/*
 * GetSaleTicket
 */
class GetSaleTicket {
    /* @var string $ticketId  */
    private $ticketId;
/* @var string $partnerTicketId  */
    private $partnerTicketId;
/* @var string $partnerTicketStatus &#x60;OnHold&#x60;: The ticket is curretly held in a pending state and has not completed purchase (expected status after Create Sale request). &#x60;Created&#x60;: The ticket has been created successfully (expected status after Commit Sale request). &#x60;Cancelled&#x60;: The ticket has been cancelled and refunded successfully. &#x60;CancelledNoRefund&#x60;: The ticket has been cancelled successfully but no refund was given to the customer. &#x60;Redeemed&#x60;: The ticket has been redeemed by the customer. &#x60;NoShow&#x60;: The ticket&#39;s localDate has expired without being redeemed and cannot be redeemed or cancelled for a refund. &#x60;Expired&#x60;: The ticket&#39;s localDate has expired and cannot be redeemed or cancelled for a refund  */
    private $partnerTicketStatus;
/* @var string $partnerTicketBarcode  */
    private $partnerTicketBarcode;
/* @var string $utcTicketRedemptionDateTime  */
    private $utcTicketRedemptionDateTime;
}
