<?php
namespace Unicommerce\ExportJob\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResourceConnection;

class ApiCall extends AbstractHelper
{
	protected $helperData;
	protected $curl;
	protected $configWriter;
	protected $resourceConnection;

	public function __construct(
		\Unicommerce\ExportJob\Helper\Data $helperData,
		\Magento\Framework\HTTP\Client\Curl $curl,
		WriterInterface $configWriter,
		ResourceConnection $resourceConnection
		
	)
	{
		$this->helperData = $helperData;
		$this->curl = $curl;
		$this->configWriter = $configWriter;
		$this->resourceConnection = $resourceConnection;
	}
	
	public function generateToken()
	{
		$params = array(
				"grant_type" => $this->helperData->getGrantType(),
				"client_id" => $this->helperData->getClientIid(),
				"username" => $this->helperData->getUsername(),
				"password" => $this->helperData->getPassword(),
			);
		$queryString = http_build_query($params);
		$url = $this->helperData->getGenerateTokenUrl()."?".$queryString;
		$this->curl->get($url);
		$responce = $this->curl->getBody();
		$result = json_decode($responce);
		$token = $result->access_token;
		$this->setToken($token);
		return $token;
	}
	
	public function createInvoice()
	{
		$url = $this->helperData->getInvoiceCreateUrl();
		// get method
		$this->curl->get($url);
		// output of curl request
		$this->curl->setHeaders([
			"Authorization"=>"bearer ".$token,
			"Facility"=> $facility
		]);
		$result = $this->curl->getBody();
	}
	
	public function setToken($token)
	{
		$path = "unicommerce/general/token";
		$this->configWriter->save($path, $token, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
	}
	
	public function getFacility($facilityName)
	{
		$companies = [
			'nanostuffs' => 'Awaiting Procurement',
			'SM_TECHNO' => 'SM TECHNO',
			'Sellex_Incorp' => 'Sellex Incorp',
			'SARTECH' => 'Sartech Solutions Pvt Ltd',
			'Vison' => 'Vison Industrial Hub',
			'Shreeji_Chemtech' => 'Shreeji Chemtech',
			'stgnanostuffs' => 'stgnanostuffs'
		];
			$key = array_search($facilityName, $companies);
			if ($key !== false) {
				return $key;
			} else {
				return null;
			}
	}
	public function getFacilityAndInvoiceCode($displayOrderCode)
	{
		$connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('unicommerce_api_data'); // Replace with your actual table name

        $select = $connection->select()
            ->from($tableName, ['invoice_code', 'facility'])
            ->where('display_order_code = ?', $displayOrderCode)
            ->where('invoice_code IS NOT NULL')
            ->where('invoice_code != ?', '')
            ->where('facility IS NOT NULL')
            ->where('facility != ?', '')
			->group('invoice_code');

        return $connection->fetchRow($select);
		
	}
	
	
}