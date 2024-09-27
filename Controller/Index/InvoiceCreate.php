<?php
namespace Unicommerce\ExportJob\Controller\Index;

use Magento\Framework\Controller\Result\RawFactory;
use \Magento\Framework\Controller\ResultFactory;

class InvoiceCreate extends \Magento\Framework\App\Action\Action
{
	  protected $_pageFactory;
	  protected $helperApiCall;
	  protected $helper;
	  protected $request;
	  protected $_messageManager;
	  protected $resultRawFactory;
	 
	  public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Unicommerce\ExportJob\Helper\ApiCall $helperApiCall,
		\Unicommerce\ExportJob\Helper\Data $helper,
		\Magento\Framework\App\RequestInterface $request,
		RawFactory $resultRawFactory,
		\Magento\Framework\Message\ManagerInterface $messageManager
	  )
	  {
		$this->_pageFactory = $pageFactory;
		$this->helperApiCall = $helperApiCall;
		$this->helper = $helper;
		$this->request = $request;
		$this->resultRawFactory = $resultRawFactory;
		$this->_messageManager = $messageManager;
		return parent::__construct($context);
	  }

	public function execute()
	{
		$displayOrderCode = $this->request->getParam('increment_id');
		$data = $this->helperApiCall->getFacilityAndInvoiceCode($displayOrderCode);		
		$token  = $this->helper->getToken();
		if(!isset($data['invoice_code']) && !isset($data['facility']))
		{
			$this->_messageManager->addError(__("invoice not found"));
			return;
			//$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
			//$resultRedirect->setUrl($this->_redirect->getRefererUrl());
		}else{
		
			$invoiceCodes = $data['invoice_code'];
			$facility = $this->helperApiCall->getFacility($data['facility']);	
			
			//$invoiceCodes = $this->request->getParam('invoice_codes');
			//$facility = $this->helperApiCall->getFacility($this->request->getParam('facility'));
			$res = $this->createInvoice($token,$invoiceCodes,$facility);
			if( $res == "invalid_token")
			{
				$token  = $this->helperApiCall->generateToken();
				$res = $this->createInvoice($token,$invoiceCodes,$facility);
			}
			return $res;
		}
	}
	
	public function createInvoice($token,$invoiceCodes,$facility)
	{
	    $curl = curl_init();
		$url = $this->helper->getInvoiceCreateUrl();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url.'?invoiceCodes='.$invoiceCodes,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: bearer '.$token,
                'facility: '.$facility,
                'Content-type: application/pdf'
            ),
        ));

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);
		
		$data = json_decode($response);
		if(isset($data->error))
		{
			return $data->error;
		}else{
			$resultRaw = $this->resultRawFactory->create();
        $resultRaw->setHeader('Content-Type', 'application/pdf', true);
        $resultRaw->setHeader('Content-Disposition', 'attachment; filename="invoice.pdf"', true);
        $resultRaw->setContents($response);
        return $resultRaw;
		}
        
	}
}