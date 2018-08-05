<?php
/*
 * GetSaleResponse
 */
namespace \Models;

/*
 * GetSaleResponse
 */
class GetSaleResponse {
    /* @var \\Models\ResponseHeader $responseHeader  */
    private $responseHeader;
/* @var string $partnerSupplierBranchId  */
    private $partnerSupplierBranchId;
/* @var string $partnerSaleId  */
    private $partnerSaleId;
/* @var string $partnerSaleStatus &#x60;OnHold&#x60;: The sale is currently held in a pending state and has not completed purchase (expected status after Create Sale request). &#x60;Created&#x60;: The sale has been created successfully (expected status after Commit Sale request). &#x60;Cancelled&#x60;: The sale has been cancelled and refunded successfully. &#x60;CancelledNoRefund&#x60;: The sale has been cancelled successfully but no refund was given to the customer. &#x60;RedeemedPartial&#x60;: Some, but not all, of the tickets on this sale have been redeemed. &#x60;RedeemedAll&#x60;: All of the tickets on this sale have been redeemed. &#x60;Expired&#x60;: The localDate of all tickets on the sale have expired and the sale cannot be redeemed or cancelled for a refund.  */
    private $partnerSaleStatus;
/* @var string $partnerBarcodeSymbology  */
    private $partnerBarcodeSymbology;
/* @var string $partnerSaleBarcode  */
    private $partnerSaleBarcode;
/* @var string $utcSaleRedemptionDateTime  */
    private $utcSaleRedemptionDateTime;
/* @var \\Models\GetSaleTicket[] $partnerTickets  */
    private $partnerTickets;
}
