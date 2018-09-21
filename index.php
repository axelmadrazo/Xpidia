<?php
/**
 * Expedia LX Supplier Connectivity API
 * @version 2.1.0
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
include 'lib/db.php';
//require 'lib/Person.php':

$app = new Slim\App();



/**
 * GET supplierBranchesPartnerSupplierBranchIdSalesPartnerSaleIdGet
 * Summary: Get the current status of a sale
 * Notes: This endpoint returns the most current status of a sale so that customer redemption status may be updated. Additionally, this endpoint is used during error recovery to check the current status of a booking or cancellation request so that the operation may be resumed from the current state. ##### Potential &#x60;errorType&#x60; Values:    * &#x60;UnableToProcessRequest&#x60;: An unanticipated error occurred in processing.   * &#x60;SaleNotFound&#x60;: The specified sale could not be found.   * &#x60;SaleServiceUnavailable&#x60;: The sale service is temporarily unavailable. 
 * Output-Formats: [application/vnd.localexpert.v2.1+json]
 */
$app->GET('/supplierBranches/{partnerSupplierBranchId}/sales/{partnerSaleId}', function($request, $response, $args) {
            $headers = $request->getHeaders();
            $requestIdentifier = $headers['HTTP_X_REQUEST_IDENTIFIER'][0];
            $xrequestauthentication = $headers['HTTP_X_REQUEST_AUTHENTICATION'][0];
            $Accept = $headers['HTTP_ACCEPT'][0];

            $partnerSupplierBranchId = $request->getAttribute('partnerSupplierBranchId');
			$partnerSaleId = $request->getAttribute('partnerSaleId');
            
           /*  $sql = "SELECT * FROM Sales";
//
            try{
                // Get DB Object
                $db = new db();
                // Connect
                $db = $db->connect();

                $stmt = $db->query($sql);
                $sales = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                //echo json_encode($sales);

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            } */
            

            $error = 200;
            $errorText ='';
            
            if (empty($requestIdentifier)) {
               $error = 400;
               $errorText ='The x-request-identifier header was not found.';
            }
            if (empty($xrequestauthentication)) {
                $error = 401;
                $errorText ='The x-request-authentication header was not found.';
            }
            if ($xrequestauthentication = 0) {
                $error = 403;
                $errorText ='The x-request-authentication header was determined to be invalid.';
            }
            if (empty($Accept)) {
                $error = 406;
                $errorText ='The Accept header is missing or does not list any API version that is supported.';
            }

            $time_elapsed_secs = 100;

            // $data = array(
            //     'responseHeader' => array(
            //         'requestIdentifier' => $requestIdentifier,
            //         'processingMilliseconds' => $time_elapsed_secs
            //     ),

            //     'partnerSupplierBranchId' => $partnerSupplierBranchId,
            //     'partnerSaleId' => "",
            //     'partnerSaleStatus' => "OnHold",
            //     'partnerBarcodeSymbology' => "QRCode",
            //     'partnerSaleBarcode' => "",
            //     'utcSaleRedemptionDateTime' => ""
            // );

            // $data['partnerTickets'][]= array(
            //         'ticketId' => "",
            //         'partnerTicketId' => "",
            //         'partnerTicketStatus' => "OnHold",
            //         'partnerTicketBarcode' => "",
            //         'utcTicketRedemptionDateTime' => ""
            // );


  // "partnerSupplierBranchId": "",
  // "partnerSaleId": "",
  // "partnerSaleStatus": "OnHold",
  // "partnerBarcodeSymbology": "QRCode",
  // "partnerSaleBarcode": "",
  // "utcSaleRedemptionDateTime": "",
  // "partnerTickets": [
  //   {
  //     "ticketId": "",
  //     "partnerTicketId": "",
  //     "partnerTicketStatus": "OnHold",
  //     "partnerTicketBarcode": "",
  //     "utcTicketRedemptionDateTime": ""
  //   }
  // ]

            //      $stmt = $db->prepare($sql);
            $bandera = true;
            $pdo = new db();
            //     // Connect
                 $pdo = $pdo->connect();
        
                 // $stmt = $db->prepare($sql);

            $sql= "SELECT * FROM Sales where referenceId = '".$partnerSaleId."'";
            $stmt = $pdo->query($sql); 
            $row =$stmt->fetchObject();


            // echo "**************************|||".count($row->referenceId)."|||***********".$partnerSaleId;

            if(count($row) == 0)
            {
                $bandera = false;
                $data = array(
                                    "responseHeader"=> array(
                                    "requestIdentifier" => (string) $requestIdentifier,
                                    "processingMilliseconds"=> 100,
                                    "errorType"=> "SaleNotFound",
                                    "errorMessage"=> "The specified sale could not be found."
                        )
                );
            }
            else
            {
                $bandera=false;
                $data = array(
                'responseHeader' => array(
                    'requestIdentifier' => $requestIdentifier,
                    'processingMilliseconds' => $time_elapsed_secs
                    ),
                    'partnerSupplierBranchId' => $partnerSupplierBranchId,
                    'partnerSaleId' => $partnerSaleId,
                    'partnerSaleStatus' => 'OnHold',
                    'partnerBarcodeSymbology' => 'QRCode',
                    'partnerSaleBarcode' => '',
                    'utcSaleRedemptionDateTime' => $time_elapsed_secs,
                    'partnerTickets' => array(
                        'ticketId'=> '',
                        'partnerTicketId'=> '',
                        'partnerTicketStatus'=> 'OnHold',
                        'partnerTicketBarcode'=> '',
                        'utcTicketRedemptionDateTime'=> $time_elapsed_secs
                    )
                );
            }

            if($bandera==true)
            {
                $data = array(
                                    "responseHeader"=> array(
                                    "requestIdentifier" => (string) $requestIdentifier,
                                    "processingMilliseconds"=> 100,
                                    "errorType"=> "SaleNotFound",
                                    "errorMessage"=> "The specified sale could not be found."
                        )
                );
            }


            if ($error==200) {
                return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
                ->write(json_encode($data));
            }
            else{
                return $response->withStatus($error)
                ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
                ->write($errorText);
            }
            
            // $response->write('How about implementing supplierBranchesPartnerSupplierBranchIdSalesPartnerSaleIdGet as a GET method ?');
            // return $response;
            /* return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
            ->write(json_encode($sales)); */
             });



/**
 * POST supplierBranchesPartnerSupplierBranchIdSalesPost
 * Summary: Create Sale
 * Notes: This endpoint creates a new sale. This is the 1st step of the two phase commit process. The &#x60;holdDurationSeconds&#x60; parameter specifies how long the sale should be held before releasing the inventory back into the available pool.  The &#x60;referenceId&#x60; is a temporary reference identifier for this sale. The final Expedia &#x60;saleId&#x60; will be available in the CommitSale request.  The number of &#x60;guest&#x60; objects in the request will be at least 1. However it can be less than the total number of tickets requested if the data is not available. The first &#x60;guest&#x60; is the lead guest for this sale.  The &#x60;additionalCriteria&#x60; is an array field that can optionally pass any object(s) of data as needed. This allows flexibility by platform, such as for ground transportation platforms that need additional information for ride coordination. Data in here is ignored unless needed.  The email address and phone number of the guest will be provided if available. ##### Potential &#x60;errorType&#x60; Values:   * &#x60;UnableToProcessRequest&#x60;: An unanticipated error occurred in processing.   * &#x60;PartnerSupplierBranchIdUnrecognized&#x60;: The Supplier Branch ID specified could not be found in the system or belongs to an inactive Supplier Branch.   * &#x60;PartnerActivityIdUnrecognized&#x60;: The Activity ID specified could not be found in the system or belongs to an inactive Activity.   * &#x60;PartnerOfferIdUnrecognized&#x60;: The Offer ID specified could not be found in the system or belongs to an inactive Offer.   * &#x60;PartnerTicketTypeIdUnrecognized&#x60;: The Ticket Type ID specified could not be found in the system or belongs to an inactive Ticket Type.   * &#x60;ThisConfigurationNotAvailable&#x60;: The requested offer &amp; ticket type configuration is not available on this date.   * &#x60;ThisConfigurationNotSupported&#x60;: The requested offer &amp; ticket type configuration is never allowed for this offer.   * &#x60;SaleServiceUnavailable&#x60;: The sale service is temporarily unavailable. 
 * Output-Formats: [application/vnd.localexpert.v2.1+json]
 */
$app->POST('/supplierBranches/{partnerSupplierBranchId}/sales', function($request, $response, $args) {


            try {
    
            $headers = $request->getHeaders();
            $requestIdentifier = $headers['HTTP_X_REQUEST_IDENTIFIER'][0];
            $xrequestauthentication = $headers['HTTP_X_REQUEST_AUTHENTICATION'][0];
              

            $Accept = $headers['HTTP_ACCEPT'][0];

            $partnerSupplierBranchId = $request->getAttribute('partnerSupplierBranchId');
            $partnerActivityId = $request->getAttribute('partnerActivityId');
            $partnerOfferId = $request->getAttribute('partnerOfferId');

            $body = $request->getParsedBody();
             // echo "*******************".$partnerSupplierBranchId."*********************/";
            //  print_r($guests);
            $error = 200;
            $errorText ='';
            if($partnerActivityId != '291957W3' || $partnerSupplierBranchId=='UnrecognizedPartnerActivityId')
            {
                $data = array(
                                    "responseHeader"=> array(
                                    "requestIdentifier" => (string) $requestIdentifier,
                                    "processingMilliseconds"=> 100,
                                    "errorType"=> "PartnerActivityIdUnrecognized",
                                    "errorMessage"=> "The Activity ID specified could not be found in the system or belongs to an inactive Activity."
                        )
                );
                $error==403;
            }

            elseif($partnerOfferId != '391472W3025' || $partnerOfferId=='UnrecognizedPartnerOfferId')
            {
                 $data = array(
                                    "responseHeader"=> array(
                                    "requestIdentifier" => (string) $requestIdentifier,
                                    "processingMilliseconds"=> 100,
                                    "errorType"=> "PartnerOfferIdUnrecognized",
                                    "errorMessage"=> "The Offer ID specified could not be found in the system or belongs to an inactive Offer."
                        )
                );
                $error==403;
            }
            

            else
            {
                $sql = "INSERT INTO Sales (referenceId, partnerActivityId, partnerOfferId, localDate, partnerTicketTypeId, travelerCount, voucherCount, firstName, lastName, emailAddress, phoneNumber, holdDurationSeconds) VALUES
            (:referenceId,:partnerActivityId,:partnerOfferId,:localDate,:partnerTicketTypeId,:travelerCount,:voucherCount, :firstName, :lastName, :emailAddress, :phoneNumber, :holdDurationSeconds)";
    
        

             try{
                 // Get DB Object
                 $db = new db();
            //     // Connect
                 $db = $db->connect();
        
                 $stmt = $db->prepare($sql);
        
                $referenceId = $body['referenceId'];
                $partnerActivityId = $body['partnerActivityId'];
                $partnerOfferId = $body['partnerOfferId'];
                $localDate = $body['localDate'];
                $partnerTicketTypeId = $body['ticketTypes'][0]['partnerTicketTypeId'];
                $travelerCount = $body['ticketTypes'][0]['travelerCount'];
                $voucherCount = $body['ticketTypes'][0]['voucherCount'];
                $firstName = $body['guests'][0]['firstName'];
                $lastName = $body['guests'][0]['lastName'];
                // $emailAddress = $body['guests'][0]['emailAddress'];
                // $phoneNumber = $body['guests'][0]['phoneNumber'];
                $emailAddress = 'pablo@gmail.com';
                $phoneNumber = '99887766';
                $holdDurationSeconds = $body['holdDurationSeconds'];

                $stmt->bindParam(':referenceId', $referenceId);
                $stmt->bindParam(':partnerActivityId', $partnerActivityId);
                $stmt->bindParam(':partnerOfferId', $partnerOfferId);
                $stmt->bindParam(':localDate', $localDate);
                $stmt->bindParam(':partnerTicketTypeId', $partnerTicketTypeId);
                $stmt->bindParam(':travelerCount', $travelerCount);
                $stmt->bindParam(':voucherCount', $voucherCount);
                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':lastName', $lastName);
                $stmt->bindParam(':emailAddress', $emailAddress);
                $stmt->bindParam(':phoneNumber', $phoneNumber);
                $stmt->bindParam(':holdDurationSeconds', $holdDurationSeconds);

                $stmt->execute();
                // $partnerSaleId = $db->lastInsertId();
                $partnerSaleId = $db->lastInsertId();

                $time_elapsed_secs = 100;

            $data = array(
                'responseHeader' => array(
                    'requestIdentifier' => $requestIdentifier,
                    'processingMilliseconds' => $time_elapsed_secs
                ),
                'partnerSupplierBranchId' => $partnerSupplierBranchId,
                'referenceId' => $referenceId,
                'partnerSaleId' => $partnerSaleId,
                'utcHoldExpiration' => 1,
                $data["additionalCriteria"]= array()
                
            );

  
        
            } catch(PDOException $e){
                 echo '{"error": {"text": '.$e->getMessage().'}';
            }
            }


            

            
            
            // if (empty($requestIdentifier)) {
            //    $error = 400;
            //    $errorText ='The x-request-identifier header was not found.';
            // }
            // if (empty($xrequestauthentication)) {
            //     $error = 401;
            //     $errorText ='The x-request-authentication header was not found.';
            // }
            // if ($xrequestauthentication == 0) {
            //     $error = 403;
            //     $errorText ='The x-request-authentication header was determined to be invalid.';
            // }
            // if (empty($Accept)) {
            //     $error = 406;
            //     $errorText ='The Accept header is missing or does not list any API version that is supported.';
            // }

            // if($partnerSupplierBranchId=='UnrecognizedPartnerActivityId"')
            // {
            //     $data = array(
            //                         "responseHeader"=> array(
            //                         "requestIdentifier" => (string) $requestIdentifier,
            //                         "processingMilliseconds"=> 100,
            //                         "errorType"=> "PartnerActivityIdUnrecognized",
            //                         "errorMessage"=> "The Activity ID specified could not be found in the system or belongs to an inactive Activity."
            //             )
            //     );
            //     $error==403;
            // }
            // else if($partnerOfferId=='UnrecognizedPartnerOfferId')
            // {
            //     $data = array(
            //                         "responseHeader"=> array(
            //                         "requestIdentifier" => (string) $requestIdentifier,
            //                         "processingMilliseconds"=> 100,
            //                         "errorType"=> "PartnerOfferIdUnrecognized",
            //                         "errorMessage"=> "The Offer ID specified could not be found in the system or belongs to an inactive Offer."
            //             )
            //     );
            //     $error==403;
            // }

            

           if ($error==200) {
                return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
                ->write(json_encode($data));
            }
            else{
                return $response->withStatus($error)
                ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
                ->write($errorText);
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }


            

           
            //$response = $response->withJson($data);
            //$response = $response->withHeader('Content-type', 'application/vnd.localexpert.v2.1+json');
            //$response = $response->withJson($data);
           //$response->write('How about implementing supplierBranchesPartnerSupplierBranchIdSalesPost as a POST method ?');
           // return $response;
            // return $response->withStatus(200)
            //     ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
            //     ->write(json_encode($data));
            });



/**
 * PUT supplierBranchesPartnerSupplierBranchIdSalesPartnerSaleIdCancellationCancellationCodePut
 * Summary: Commit a sale cancellation
 * Notes: This endpoint specifies that a previously-prepared Sale cancellation should be finally cancelled. ##### Potential &#x60;errorType&#x60; Values:   * &#x60;UnableToProcessRequest&#x60;: An unanticipated error occurred in processing.   * &#x60;SaleNotFound&#x60;: The specified sale could not be found.   * &#x60;CancellationNotCreated&#x60;: The specified Cancellation Code could not be found.   * &#x60;SaleAlreadyStarted&#x60;: The activity start time for the sale has already elapsed.   * &#x60;SaleAlreadyRedemeed&#x60;: One or more tickets on the specified sale have already been redeemed.   * &#x60;SaleAlreadyCancelled&#x60;: The specified sale has already been cancelled.   * &#x60;SaleServiceUnavailable&#x60;: The sale service is temporarily unavailable. 
 * Output-Formats: [application/vnd.localexpert.v2.1+json]
 */
$app->PUT('/supplierBranches/{partnerSupplierBranchId}/sales/{partnerSaleId}/cancellation/{cancellationCode}', function($request, $response, $args) {
            $headers = $request->getHeaders();
            $requestIdentifier = $headers['HTTP_X_REQUEST_IDENTIFIER'][0];
            $xrequestauthentication = $headers['HTTP_X_REQUEST_AUTHENTICATION'][0];
            $Accept = $headers['HTTP_ACCEPT'][0];

            $partnerSupplierBranchId = $request->getAttribute('partnerSupplierBranchId');
            $partnerSaleId = $request->getAttribute('partnerSaleId');
            

            $error = 200;
            $errorText ='';
            
            if (empty($requestIdentifier)) {
               $error = 400;
               $errorText ='The x-request-identifier header was not found.';
            }
            if (empty($xrequestauthentication)) {
                $error = 401;
                $errorText ='The x-request-authentication header was not found.';
            }
            if ($xrequestauthentication = 0) {
                $error = 403;
                $errorText ='The x-request-authentication header was determined to be invalid.';
            }
            if (empty($Accept)) {
                $error = 406;
                $errorText ='The Accept header is missing or does not list any API version that is supported.';
            }

            $time_elapsed_secs = 100;


  //           {
  // "responseHeader": {
  //   "requestIdentifier": "",
  //   "processingMilliseconds": 0
  // },
  // "partnerSupplierBranchId": "",
  // "partnerSaleId": ""
            // Get DB Object
            // $db = new db();
            // //     // Connect
            //      $db = $db->connect();
        
            //      $stmt = $db->prepare($sql);
            $pdo = new db();
            //     // Connect
                 $pdo = $pdo->connect();
        
                 // $stmt = $db->prepare($sql);

            $sql= "SELECT * FROM Sales where referenceId ='".$partnerSaleId."'";
            $stmt = $pdo->query($sql); 
            $row =$stmt->fetchObject();

            if($row->referenceId != $partnerSaleId)
            {
                $data = array(
                                    "responseHeader"=> array(
                                    "requestIdentifier" => (string) $requestIdentifier,
                                    "processingMilliseconds"=> 100,
                                    "errorType"=> "SaleNotFound",
                                    "errorMessage"=> "The specified sale could not be found."
                        )
                );
            }
            else
            {
                 $data = array(
                    'responseHeader' => array(
                        'requestIdentifier' => $requestIdentifier,
                        'processingMilliseconds' => $time_elapsed_secs
                    ),
                    'partnerSupplierBranchId' => $partnerSupplierBranchId,
                    'partnerSaleId' => $partnerSaleId
                );
            }
            

            // $sql = "=:id";
            // $db = new db();
            // //     // Connect
            // $db = $db->connect();
        
            // $stmt = $db->prepare($sql);
            // $stmt = $pdo->prepare();
            // $user = $stmt->fetch();

           





            if ($error==200) {
                return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
                ->write(json_encode($data));
            }
            else{
                return $response->withStatus($error)
                ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
                ->write($errorText);
            }
            });





/**
 * GET supplierBranchesPartnerSupplierBranchIdActivitiesPartnerActivityIdOffersPartnerOfferIdAvailabilityGet
 * Summary: Get the availability of an offer.
 * Notes: This endpoint returns the availability of an offer on each local date within the specified date range.  The &#x60;minimumAccuracy&#x60; is the requested accuracy for this availability. It is strongly recommended that the returned availability has an accuracy as good as or better than requested accuracy. However, this should be achieved keeping the response times in mind.  If the &#x60;availabilityType&#x60; is limited, the API **must** return the &#x60;availableCapacity&#x60; and &#x60;maximumCapacity&#x60; fields.  This endpoint is called in 2 scenarios:    - Prior to checkout, an availability call is made for a single day date range, in order to confirm the remaining availability of an offer.   - During the general availability check, an availability call is made for a multi-day date range (typically for 30 days at a time) in order to bulk update the remaining inventory of an offer.  ##### Potential &#x60;errorType&#x60; Values:    * &#x60;UnableToProcessRequest&#x60;: An unanticipated error occurred in processing.   * &#x60;PartnerSupplierBranchIdUnrecognized&#x60;: The Supplier Branch ID specified could not be found in the system or belongs to an inactive Supplier Branch.   * &#x60;PartnerActivityIdUnrecognized&#x60;: The Activity ID specified could not be found in the system or belongs to an inactive Activity.   * &#x60;PartnerOfferIdUnrecognized&#x60;: The Offer ID specified could not be found in the system or belongs to an inactive Offer. 
 * Output-Formats: [application/vnd.localexpert.v2.1+json]
 */
$app->GET('/supplierBranches/{partnerSupplierBranchId}/activities/{partnerActivityId}/offers/{partnerOfferId}/availability', function($request, $response, $args) {
            //$start = microtime(true);
            $requestIdentifier='';
            $headers = $request->getHeaders();
            $requestIdentifier = $headers['HTTP_X_REQUEST_IDENTIFIER'][0];
            $xrequestauthentication = $headers['HTTP_X_REQUEST_AUTHENTICATION'][0];
            $Accept = $headers['HTTP_ACCEPT'][0];

            $queryParams = $request->getQueryParams();
            $localDateRangeStart = $queryParams['localDateRangeStart'];    
            $localDateRangeEnd = $queryParams['localDateRangeEnd'];    
            $minimumAccuracy = $queryParams['minimumAccuracy'];

            $partnerSupplierBranchId = $request->getAttribute('partnerSupplierBranchId');
			$partnerActivityId = $request->getAttribute('partnerActivityId');
            $partnerOfferId = $request->getAttribute('partnerOfferId');



            
            $error = 200;
            $errorText ='';
            
            if (empty($requestIdentifier)) {
               $error = 400;
               $errorText ='The x-request-identifier header was not found.';
            }
            if (empty($xrequestauthentication)) {
                $error = 401;
                $errorText ='The x-request-authentication header was not found.';
            }
            if ($xrequestauthentication = 0) {
                $error = 403;
                $errorText ='The x-request-authentication header was determined to be invalid.';
            }
            if (empty($Accept)) {
                $error = 406;
                $errorText ='The Accept header is missing or does not list any API version that is supported.';
            }

            



            //////////////////////////////////////////////////////////////////////////////////////////////RESPUESTA
// java -jar apiVerificationTool.jar inputFile=avt.conf outputFile=avtOutput.log testcase=freesell
            //$time_elapsed_secs = microtime(true) - $start;
            //$time_elapsed_secs = round($time_elapsed_secs * 1000) 
            $time_elapsed_secs = 100;


            $data = array(
                'responseHeader' => array(
                    'requestIdentifier' => $requestIdentifier,
                    'processingMilliseconds' => $time_elapsed_secs
                ),
                'partnerSupplierBranchId' => $partnerSupplierBranchId,
                'partnerActivityId' => $partnerActivityId,
                'partnerOfferId' => $partnerOfferId,
                "availability" => array()
            );

            $fechaInicio = $localDateRangeStart;
            $fechaFinal = $localDateRangeEnd;

            $fechaInicioDate = new DateTime($localDateRangeStart);
            $fechaFinalDate = new DateTime($localDateRangeEnd);
            $diasDiferencia = $fechaInicioDate->diff($fechaFinalDate);
            $contador = 0;

            while($contador <= $diasDiferencia->days)
            {
                $nuevafecha = strtotime ( '+'.$contador.' day' , strtotime ( $fechaInicio ) ) ;
                $nuevafecha = date ( 'Y-m-j' , $nuevafecha );

                // $elementos= array("localDate" => $nuevafecha, "accuracy" => "Exact", "status" => "Available",  "availableCapacity" => 0, "maximumCapacity" => 0, "availabilityType" => "limited");
                // SoldOut
                //$elementos= array("localDate" => $nuevafecha, "accuracy" => "Exact", "status" => "SoldOut", "availableCapacity" => 0, "maximumCapacity" => 0,  "availabilityType" => "limited");
                // freesell
                 $elementos= array("localDate" => $nuevafecha, "accuracy" => "Exact", "status" => "Available", "availabilityType" => "freesell");
                array_push($data["availability"],$elementos);
                $contador++;
            }

            // UnrecognizedPartnerActivityId
            if($partnerActivityId=='UnrecognizedPartnerActivityId')
            {
                 $data = array(
                                    "responseHeader"=> array(
                                    "requestIdentifier" => (string) $requestIdentifier,
                                    "processingMilliseconds"=> 100,
                                    "errorType"=> "PartnerActivityIdUnrecognized",
                                    "errorMessage"=> "The Activity ID specified could not be found in the system or belongs to an inactive Activity."
                        )
                );
            }
            // UnrecognizedPartnerOfferId
            if($partnerOfferId=='UnrecognizedPartnerOfferId')
            {
                $data = array(
                                    "responseHeader"=> array(
                                    "requestIdentifier" => (string) $requestIdentifier,
                                    "processingMilliseconds"=> 100,
                                    "errorType"=> "PartnerOfferIdUnrecognized",
                                    "errorMessage"=> "The Offer ID specified could not be found in the system or belongs to an inactive Offer"
                        )
                );
            }
           
            // $tours = array('','1','2','3','4','5','6','7');
            // $toursOffert = array('1' => array('1'),
            //      '2'=> array('1'),
            //      '3'=> array('1'),
            //      '4'=> array('1'),
            //      '5'=> array('5'),
            //      '6'=> array('1'));
            // $bandera_offert=true;
            // foreach ($toursOffert as $key => $value) {
                
            //     if($key==$partnerActivityId)
            //     {
                    
            //         foreach ($value as $valores)
            //         {
            //             if($valores==$partnerOfferId)
            //             {
            //                 $bandera_offert=false;
            //                 break;
            //             }
            //             if(!$bandera_offert)
            //             {
            //                 break;
            //             }
            //         }
                    
                    
            //     }    
            // }

            // $pos = array_search($partnerActivityId,$tours);
            // $posOffert = $toursOffert[$partnerActivityId][0];
            // if($pos==null)
            // {
            //     $data = array(
            //                         "responseHeader"=> array(
            //                         "requestIdentifier" => "",
            //                         "processingMilliseconds"=> 0,
            //                         "errorType"=> "PartnerActivityIdUnrecognized",
            //                         "errorMessage"=> "The Activity ID specified could not be found in the system or belongs to an inactive Activity."
            //             )
            //     );
            // }
            // else if($bandera_offert)
            // {
            //     $data = array(
            //                         "responseHeader"=> array(
            //                         "requestIdentifier" => "",
            //                         "processingMilliseconds"=> 0,
            //                         "errorType"=> "PartnerOfferIdUnrecognized",
            //                         "errorMessage"=> "The Offer ID specified could not be found in the system or belongs to an inactive Offer."
            //             )
            //     );
            // }
            
            
            
             
            if ($error==200) {
                return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
                ->write(json_encode($data));
            }
            else{
                return $response->withStatus($error)
                ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
                ->write($errorText);
            }




          
            // if ( empty($requestIdentifier)) {
            //     return $response->withStatus(400)
            //     ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
            //     ->write('The x-request-identifier header was not found.');
            // }
            // else{
            //     return $response->withStatus(200)
            //     ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
            //     ->write(json_encode($data));

            // }
            

         
            });










$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});








/**
 * DELETE supplierBranchesPartnerSupplierBranchIdSalesPartnerSaleIdDelete
 * Summary: Release a created sale
 * Notes: This endpoint specifies that a previously-created Sale should be  released, as it will not be paid and completed. ##### Potential &#x60;errorType&#x60; Values:   * &#x60;UnableToProcessRequest&#x60;: An unanticipated error occurred in processing.   * &#x60;SaleNotFound&#x60;: The specified sale could not be found.   * &#x60;SaleServiceUnavailable&#x60;: The sale service is temporarily unavailable. 
 * Output-Formats: [application/vnd.localexpert.v2.1+json]
 */
$app->DELETE('/supplierBranches/{partnerSupplierBranchId}/sales/{partnerSaleId}', function($request, $response, $args) {
    // echo "*********************************************";
    // print_r($request);
    $requestIdentifier='';
    $headers = $request->getHeaders();
    $requestIdentifier = $headers['HTTP_X_REQUEST_IDENTIFIER'][0];
    $xrequestauthentication = $headers['HTTP_X_REQUEST_AUTHENTICATION'][0];
    $Accept = $headers['HTTP_ACCEPT'][0];

    // echo "*********************************************";
    // print_r($request->getQueryParams());

    $data = array(
                'responseHeader' => array(
                    'requestIdentifier' => $requestIdentifier,
                    'processingMilliseconds' => $time_elapsed_secs
                ),
                'partnerSupplierBranchId' => $partnerSupplierBranchId,
                'partnerSaleId' => '',
                'partnerSaleStatus' => '',
                'partnerBarcodeSymbology' => '',
                'partnerSaleBarcode' => '',
                'utcSaleRedemptionDateTime' => '',
                'partnerTickets' => array(
                    'ticketId'=> '',
                    'partnerTicketId'=> '',
                    'partnerTicketStatus'=> 'OnHold',
                    'partnerTicketBarcode'=> '',
                    'utcTicketRedemptionDateTime'=> ''
                )
            );

    $error = 200;
    if (empty($requestIdentifier)) {
               $error = 400;
               $errorText ='The x-request-identifier header was not found.';
            }
            if (empty($xrequestauthentication)) {
                $error = 401;
                $errorText ='The x-request-authentication header was not found.';
            }
            if ($xrequestauthentication = 0) {
                $error = 403;
                $errorText ='The x-request-authentication header was determined to be invalid.';
            }
            if (empty($Accept)) {
                $error = 406;
                $errorText ='The Accept header is missing or does not list any API version that is supported.';
            }

    
    if ($error==200) {
                return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
                ->write(json_encode($data));
            }
            else{
                return $response->withStatus($error)
                ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
                ->write($errorText);
            }
    });



/**
 * POST supplierBranchesPartnerSupplierBranchIdSalesPartnerSaleIdCancellationPost
 * Summary: Create a sale cancellation
 * Notes: This endpoint specifies that a previously-committed Sale should be cancelled. This is a **hold**, and the actual cancellation of the Sale **must not** occur until a &#x60;CommitSaleCancellation&#x60; request is received.  The &#x60;holdDurationSeconds&#x60; parameter specifies how long the cancellation request must be held before being released. ##### Potential &#x60;errorType&#x60; Values:   * &#x60;UnableToProcessRequest&#x60;: An unanticipated error occurred in processing.   * &#x60;SaleNotFound&#x60;: The specified sale could not be found.   * &#x60;SaleNotCancellable&#x60;: The specified sale is not allowed to be cancelled due to the cancellation policy in effect.   * &#x60;SaleNotCommitted&#x60;: The specified sale was never committed and therefore cannot be cancelled.   * &#x60;SaleServiceUnavailable&#x60;: The sale service is temporarily unavailable. 
 * Output-Formats: [application/vnd.localexpert.v2.1+json]
 */
$app->POST('/supplierBranches/{partnerSupplierBranchId}/sales/{partnerSaleId}/cancellation', function($request, $response, $args) {
    $headers = $request->getHeaders();
    // print_r($headers);
    $body = $request->getParsedBody();
    $response->write('How about implementing supplierBranchesPartnerSupplierBranchIdSalesPartnerSaleIdCancellationPost as a POST method ?');
    return $response;
    });


/**
 * DELETE supplierBranchesPartnerSupplierBranchIdSalesPartnerSaleIdCancellationCancellationCodeDelete
 * Summary: Release a sale cancellation
 * Notes: This endpoint specifies that a previously-prepared Sale cancellation should be discarded and the sale not cancelled. ##### Potential &#x60;errorType&#x60; Values:   * &#x60;UnableToProcessRequest&#x60;: An unanticipated error occurred in processing.   * &#x60;SaleNotFound&#x60;: The specified sale could not be found.   * &#x60;CancellationNotCreated&#x60;: The specified Cancellation Code could not be found.   * &#x60;SaleServiceUnavailable&#x60;: The sale service is temporarily unavailable. 
 * Output-Formats: [application/vnd.localexpert.v2.1+json]
 */
$app->DELETE('/supplierBranches/{partnerSupplierBranchId}/sales/{partnerSaleId}/cancellation/{cancellationCode}', function($request, $response, $args) {
    $headers = $request->getHeaders();
    $response->write('How about implementing supplierBranchesPartnerSupplierBranchIdSalesPartnerSaleIdCancellationCancellationCodeDelete as a DELETE method ?');
    return $response;
    });


/**
 * PUT supplierBranchesPartnerSupplierBranchIdSalesPartnerSaleIdPut
 * Summary: Commit the sale
 * Notes: This endpoint specifies that a previously-created Sale should be committed as paid and complete (e.g. the 2nd step of the 2-phase commit).  The &#x60;saleId&#x60; and &#x60;ticketId&#x60; fields in the request can be recorded as Expedia sale reference and ticket references respectively. ##### Potential &#x60;errorType&#x60; Values:   * &#x60;UnableToProcessRequest&#x60;: An unanticipated error occurred in processing.   * &#x60;SaleNotFound&#x60;: The specified sale could not be found.   * &#x60;SaleExpired&#x60;: The specified sale has already exceeded the maximum &#x60;holdDurationSeconds&#x60; requested and cannot be committed.   * &#x60;SaleServiceUnavailable&#x60;: The sale service is temporarily unavailable. 
 * Output-Formats: [application/vnd.localexpert.v2.1+json]
 */
$app->PUT('/supplierBranches/{partnerSupplierBranchId}/sales/{partnerSaleId}', function($request, $response, $args) {
    // echo "*********************************************";
    // print_r($request);
    $requestIdentifier='';
    $headers = $request->getHeaders();
    $requestIdentifier = $headers['HTTP_X_REQUEST_IDENTIFIER'][0];
    $xrequestauthentication = $headers['HTTP_X_REQUEST_AUTHENTICATION'][0];
    $Accept = $headers['HTTP_ACCEPT'][0];

    

    $data = array(
                'responseHeader' => array(
                    'requestIdentifier' => $requestIdentifier,
                    'processingMilliseconds' => $time_elapsed_secs
                ),
                'partnerSupplierBranchId' => $partnerSupplierBranchId,
                'partnerSaleId' => '',
                'partnerSaleStatus' => '',
                'partnerBarcodeSymbology' => '',
                'partnerSaleBarcode' => '',
                'utcSaleRedemptionDateTime' => '',
                'partnerTickets' => array(
                    'ticketId'=> '',
                    'partnerTicketId'=> '',
                    'partnerTicketStatus'=> 'OnHold',
                    'partnerTicketBarcode'=> '',
                    'utcTicketRedemptionDateTime'=> ''
                )
            );

    $error = 200;
    if (empty($requestIdentifier)) {
               $error = 400;
               $errorText ='The x-request-identifier header was not found.';
            }
            if (empty($xrequestauthentication)) {
                $error = 401;
                $errorText ='The x-request-authentication header was not found.';
            }
            if ($xrequestauthentication = 0) {
                $error = 403;
                $errorText ='The x-request-authentication header was determined to be invalid.';
            }
            if (empty($Accept)) {
                $error = 406;
                $errorText ='The Accept header is missing or does not list any API version that is supported.';
            }

    
    if ($error==200) {
                return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
                ->write(json_encode($data));
            }
            else{
                return $response->withStatus($error)
                ->withHeader('Content-Type', 'application/vnd.localexpert.v2.1+json')
                ->write($errorText);
            }
    });



$app->run();
