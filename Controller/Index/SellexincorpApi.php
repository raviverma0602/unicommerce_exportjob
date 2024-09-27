<?php
namespace Unicommerce\ExportJob\Controller\Index;

class SellexincorpApi extends \Magento\Framework\App\Action\Action
{
  protected $_pageFactory;

  protected $orderFactory;

  public function __construct(
    \Magento\Framework\App\Action\Context $context,
    \Magento\Framework\View\Result\PageFactory $pageFactory,
    \Unicommerce\ExportJob\Model\OrderFactory $orderFactory

  )
  {
    $this->_pageFactory = $pageFactory;
    $this->orderFactory = $orderFactory;
    return parent::__construct($context);
  }

  public function execute()
  {
    // $link = $this->getStatusJob();
    
    // $categories = [];

    // if (($handle = fopen($link, "r")) !== false) {
    //   if (($data = fgetcsv($handle, 100000, ",")) !== false) {
    //       $keys = $data;
    //   }
    //   while (($data = fgetcsv($handle, 100000, ",")) !== false) {
    //       $categories[] = array_combine($keys, $data);
    //   }
    //   fclose($handle);
    // }

    // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    // $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
    // // print_r($storeManager);
    // // echo "<br>";
    // $baseMediaUrl = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    // $basePath = $baseMediaUrl.'export25102023'.'.csv';

    $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/uniwareexecuteCode_Sellex.log');
    $logger = new \Zend_Log();
    $logger->addWriter($writer);
    $logger->info('Execute Code'); //To print simple text log
    $logger->info(print_r("Status Job Code -> ".$this->getStatusJob(), true)); //To print array log

    $link = $this->getStatusJob();
    
    $categories = [];

    if (($handle = fopen($link, "r")) !== false) {
        if (($data = fgetcsv($handle, 100000, ",")) !== false) {
            $keys = $data;
        }
        while (($data = fgetcsv($handle, 100000, ",")) !== false) {
            $categories[] = array_combine($keys, $data);
        }
        fclose($handle);
    }

    foreach ($categories as $category) 
    {
      $model = $this->orderFactory->create();

      $model->addData([
        'sale_order_item_code' =>                 $category['Sale Order Item Code'],
        'display_order_code' =>                   $category['Display Order Code'],
        'reverse_pickup_code'=>                   $category['Reverse Pickup Code'],
        'reverse_pickup_created_date'=>           $category['Reverse Pickup Created Date'],
        'reverse_pickup_reason'=>                 $category['Reverse Pickup Reason'],
        'notification_email'=>                    $category['Notification Email'],
        'notification_mobile'=>                   $category['Notification Mobile'],
        'require_customization'=>                 $category['Require Customization'],
        'cod'=>                                   $category['COD'],
        'shipping_address_id'=>                   $category['Shipping Address Id'],
        'category'=>                              $category['Category'],
        'invoice_code'=>                          $category['Invoice Code'],
        'invoice_created'=>                       $category['Invoice Created'],
        'ewaybill_no'=>                           $category['EWayBill No'],
        'ewaybill_date'=>                         $category['EWayBill Date'],
        'ewaybill_valid_till'=>                   $category['EWayBill Valid Till'],
        'shipping_address_name'=>                 $category['Shipping Address Name'],
        'shipping_address_line_1'=>               $category['Shipping Address Line 1'],
        'shipping_address_line_2'=>               $category['Shipping Address Line 2'],
        'shipping_address_city'=>                 $category['Shipping Address City'],
        'shipping_address_state'=>                $category['Shipping Address State'],
        'shipping_address_country'=>              $category['Shipping Address Country'],
        'shipping_address_pincode'=>              $category['Shipping Address Pincode'],
        'shipping_address_phone'=>                $category['Shipping Address Phone'],
        'billing_address_id'=>                    $category['Billing Address Id'],
        'billing_address_name'=>                  $category['Billing Address Name'],
        'billing_address_line_1'=>                $category['Billing Address Line 1'],
        'billing_address_line_2'=>                $category['Billing Address Line 2'],
        'billing_address_city'=>                  $category['Billing Address City'],
        'billing_address_state'=>                 $category['Billing Address State'],
        'billing_address_country'=>               $category['Billing Address Country'],
        'billing_address_pincode'=>               $category['Billing Address Pincode'],
        'billing_address_phone'=>                 $category['Billing Address Phone'],
        'shipping_method'=>                       $category['Shipping Method'],
        'item_sku_code'=>                         $category['Item SKU Code'],
        'channel_product_id'=>                    $category['Channel Product Id'],
        'item_type_name'=>                        $category['Item Type Name'],
        'item_type_color'=>                       $category['Item Type Color'],
        'item_type_size'=>                        $category['Item Type Size'],
        'item_ype_brand'=>                        $category['Item Type Brand'],
        'channel_name'=>                          $category['Channel Name'],
        'sku_require_customization'=>             $category['SKU Require Customization'],
        'gift_wrap'=>                             $category['Gift Wrap'],
        'gift_message'=>                          $category['Gift Message'],
        'hsn_code'=>                              $category['HSN Code'],
        'mrp'=>                                   $category['MRP'],
        'total_price'=>                           $category['Total Price'],
        'selling_price'=>                         $category['Selling Price'],
        'cost_price'=>                            $category['Cost Price'],
        'prepaid_amount'=>                        $category['Prepaid Amount'],
        'subtotal'=>                              $category['Subtotal'],
        'discount'=>                              $category['Discount'],
        'gst_tax_type_code'=>                     $category['GST Tax Type Code'],
        'cgst'=>                                  $category['CGST'],
        'igst'=>                                  $category['IGST'],
        'sgst'=>                                  $category['SGST'],
        'utgst'=>                                 $category['UTGST'],
        'cess'=>                                  $category['CESS'],
        'cgst_rate'=>                             $category['CGST Rate'],
        'igst_rate'=>                             $category['IGST Rate'],
        'sgst_rate'=>                             $category['SGST Rate'],
        'utgst_rate'=>                            $category['UTGST Rate'],
        'cess_rate'=>                             $category['CESS Rate'],
        'tcs_amount'=>                            $category['TCS Amount'],
        'tax'=>                                   $category['Tax %'],
        'tax_value'=>                             $category['Tax Value'],
        'voucher_code'=>                          $category['Voucher Code'],
        'shipping_charges'=>                      $category['Shipping Charges'],
        'shipping_method_charges'=>               $category['Shipping Method Charges'],
        'cod_service_charges'=>                   $category['COD Service Charges'],
        'gift_wrap_charges'=>                     $category['Gift Wrap Charges'],
        'packet_number'=>                         $category['Packet Number'],
        'order_date'=>                            $category['Order Date as dd/mm/yyyy hh:MM:ss'],
        'sale_order_code'=>                       $category['Sale Order Code'],
        'on_hold'=>                               $category['On Hold'],
        'sale_order_status'=>                     $category['Sale Order Status'],
        'priority'=>                              $category['Priority'],
        'currency'=>                              $category['Currency'],
        'currency_conversion_rate'=>              $category['Currency Conversion Rate'],
        'sale_order_item_status'=>                $category['Sale Order Item Status'],
        'cancellation_reason'=>                   $category['Cancellation Reason'],
        'shipping_provider'=>                     $category['Shipping provider'],
        'shipping_courier'=>                      $category['Shipping Courier'],
        'shipping_arranged_by'=>                  $category['Shipping Arranged By'],
        'shipping_package_code'=>                 $category['Shipping Package Code'],
        'shipping_package_creation_date'=>        $category['Shipping Package Creation Date'],
        'shipping_package_status_code'=>          $category['Shipping Package Status Code'],
        'shipping_package_type'=>                 $category['Shipping Package Type'],
        'length'=>                                $category['Length(mm)'],
        'width'=>                                 $category['Width(mm)'],
        'height'=>                                $category['Height(mm)'],
        'delivery_time'=>                         $category['Delivery Time'],
        'tracking_number'=>                       $category['Tracking Number'],
        'dispatch_date'=>                         $category['Dispatch Date'],
        'facility'=>                              $category['Facility'],
        'return_date'=>                           $category['Return Date'],
        'return_reason'=>                         $category['Return Reason'],
        'created'=>                               $category['Created'],
        'updated'=>                               $category['Updated'],
        'combination_identifier'=>                $category['Combination Identifier'],
        'combination_description'=>               $category['Combination Description'],
        'transfer_price'=>                        $category['Transfer Price'],
        'item_code'=>                             $category['Item Code'],
        'imei'=>                                  $category['IMEI'],
        'weight'=>                                $category['Weight'],
        'gstin'=>                                 $category['GSTIN'],
        'customer_gstin'=>                        $category['Customer GSTIN'],
        'tin'=>                                   $category['TIN'],
        'payment_instrument'=>                    $category['Payment Instrument'],
        'fulfillment_tat'=>                       $category['Fulfillment TAT'],
        'adjustment_in_selling_price'=>           $category['Adjustment In Selling Price'],
        'adjustment_in_discount'=>                $category['Adjustment In Discount'],
        'store_credit'=>                          $category['Store Credit'],
        'irn'=>                                   $category['IRN'],
        'acknowledgement_number'=>                $category['Acknowledgement Number'],
        'bundle_sku_code_number'=>                $category['Bundle SKU Code Number'],
        'sku_name'=>                              $category['SKU Name'],
        'batch_code'=>                            $category['Batch Code'],
        'vendor_batch_number'=>                   $category['Vendor Batch Number'],
        'seller_sku_code'=>                       $category['Seller SKU Code'],
        'item_type_ean'=>                         $category['Item Type EAN'],
        'shipping_courier_status'=>               $category['Shipping Courier Status'],
        'shipping_tracking_status'=>              $category['Shipping Tracking Status'],
        'item_seal_id'=>                          $category['Item Seal Id'],
        'gst'=>                                   $category['GST'],
        'channel_shipping'=>                      $category['Channel Shipping'],
        'item_details'=>                          $category['Item Details'],
        'vendor_unit_price'=>                     $category['Vendor Unit Price'],
      ]);
        
      $msg = $model->getDisplayOrderCode();
      $this->logger($msg); 
      $saveData = $model->save();
    }

  }

  public function getBearerToken()
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      // CURLOPT_URL => 'https://nanostuffs.unicommerce.com/oauth/token?grant_type=password&client_id=my-trusted-client&username=tabish.khan%40unicommerce.com&password=Tabish%40123',
      CURLOPT_URL => 'https://nanostuffs.unicommerce.com/oauth/token?grant_type=password&client_id=my-trusted-client&username=amaresh.tiwari@greenhonchos.com&password=User@123',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
          'Cookie: unicommerce=app3'
      ),
    ));

    $result = curl_exec($curl);
    $data = json_decode($result);
     $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/uniwareBearerToken_Sellex.log');
    $logger = new \Zend_Log();
    $logger->addWriter($writer);
    $logger->info('token'); 
    $logger->info(print_r("token -> ".$result, true));
    return $data->access_token;
  }

  public function getCreateJob()
  {
    $bearerToken = $this->getBearerToken();

    $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/uniwareBearerTokenCheck_Sellex.log');
    $logger = new \Zend_Log();
    $logger->addWriter($writer);
    $logger->info('bearerToken'); 
    $logger->info(print_r("bearerToken -> ".$bearerToken, true));

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://nanostuffs.unicommerce.com/services/rest/v1/export/job/create',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{"exportJobTypeName":"Sale Orders","exportColums":["soicode","displayorderCode","reversePickupCode","reversePickupCreatedDate","reversePickupReason","notificationEmail","notificationMobile","requireCustomization","cod","shippingAddressId","category","invoiceCode","invoiceCreated","ewbNo","ewbDate","ewbValidTill","shippingAddressName","shippingAddressLine1","shippingAddressLine2","shippingAddressCity","shippingAddressState","shippingAddressCountry","shippingAddressPincode","shippingAddressPhone","billingAddressId","billingAddressName","billingAddressLine1","billingAddressLine2","billingAddressCity","billingAddressState","billingAddressCountry","billingAddressPincode","billingAddressPhone","shippingMethod","skuCode","channelProductId","itemTypeName","itemTypeColor","itemTypeSize","itemTypeBrand","channel","itemRequireCustomization","giftWrap","giftMessage","hsnCode","maxRetailPrice","totalPrice","sellingPrice","costPrice","prepaidAmount","subtotal","discount","gstTaxTypeCode","cgst","igst","sgst","utgst","cess","cgstrate","igstrate","sgstrate","utgstrate","cessrate","TCSAmount","tax","taxValue","voucherCode","shippingCharges","shippingMethodCharges","cashOnDeliveryCharges","giftWrapCharges","packetNumber","displayOrderDateTime","saleOrderCode","onhold","status","priority","currency","currencyConversionRate","SoiStatus","cancellationReason","shippingProvider","shippingCourier","shippingArrangedBy","ShippingPackageCode","ShippingPackageCreationDate","shippingPackageStatusCode","shippingPackageTypeCode","shippingPackageLength","shippingPackageWidth","shippingPackageHeight","deliveryTime","TrackingNumber","dispatchDate","facility","returnedDate","returnReason","created","updated","combinationIdentifier","combinationDescription","transferPrice","itemCode","imei","actualWeight","gsttin","Cgsttin","tin","paymentInstrc","fulfillmentTat","ajustmentInSellingPrice","ajustmentInDiscount","storeCredit","irn","acknowledgementNumber","bundleSkuCode","skuName","batchCode","vendorBatchNumber","sellerSkuCode","itemTypeEAN","shippingCourierStatus","shippingTrackingStatus","itemSealId","saleOrderCustomFields_GST","jsadji"],"exportFilters":[{"id":"addedOn","dateRange":{"textRange":"YESTERDAY"}}],"frequency":"ONETIME"}',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$bearerToken.'',
        'Facility: Sellex_Incorp',
        'Cookie: unicommerce=app3; JSESSIONID=9B10DD967915E5BD308F1DA6CDDDFD5E; unicommerce=app1'
      ),
    ));

    $result = curl_exec($curl);
    $data = json_decode($result);
    $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/uniwarejobCreateCheck_Sellex.log');
    $logger = new \Zend_Log();
    $logger->addWriter($writer);
    $logger->info(print_r("result_jobCreateData -> ".$result, true));
    $logger->info('jobCreate'); 
    // $logger->info(print_r("jobCreateData -> ".$data, true));
    $jobCreate = $data->jobCode;
    $logger->info(print_r("jobCreate -> ".$jobCreate, true));
    return $jobCreate;
  }

  public function getStatusJob()
  {
    $bearerToken = $this->getBearerToken();

    $createJob = $this->getCreateJob();

    $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/uniwarejobCreateLogCheck_Sellex.log');
    $logger = new \Zend_Log();
    $logger->addWriter($writer);
    $logger->info('jobCreate'); 
    $logger->info(print_r("jobCreate -> ".$createJob, true));

    $jsonData = json_encode(
      array(
        "jobCode" => $createJob
    ));
    sleep(10);

    $curls = curl_init();
    curl_setopt_array($curls, array(
      CURLOPT_URL => 'https://nanostuffs.unicommerce.com/services/rest/v1/export/job/status',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $jsonData,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$bearerToken
      ),
    ));

    $response = curl_exec($curls);
    $data = json_decode($response);
    $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/uniwaregetStatusJobCheck_Sellex.log');
    $logger = new \Zend_Log();
    $logger->addWriter($writer);
    $logger->info('filePath'); 
    $logger->info(print_r("filePath -> ".$data->filePath, true));
    return $data->filePath;
  }

  public function logger($msg)
  {   $date = date('Y-m-d');
      $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/unicommerceorderstatus/unicommerce_status_sellexincrop'.$date.'.log');
      $logger = new \Zend_Log();
      $logger->addWriter($writer);
      $logger->info($msg);
  }


}