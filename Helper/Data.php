<?php
namespace Unicommerce\ExportJob\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

	const XML_PATH_UNICOMMERCE = 'unicommerce/';

	public function getConfigValue($field, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			$field, ScopeInterface::SCOPE_STORE, $storeId
		);
	}

	public function getGeneralConfig($code, $storeId = null)
	{

		return $this->getConfigValue(self::XML_PATH_UNICOMMERCE .'general/'. $code, $storeId);
	}
	
	public function getGrantType()
	{
		return $this->getGeneralConfig('grant_type');
	}
	public function getClientIid()
	{
		return $this->getGeneralConfig('client_id');
	}
	public function getUsername()
	{
		return $this->getGeneralConfig('username');
	}
	public function getPassword()
	{
		return $this->getGeneralConfig('password');
	}
	public function getToken()
	{
		return $this->getGeneralConfig('token');
	}
	public function getGenerateTokenUrl()
	{
		return $this->getGeneralConfig('generate_token_url');
	}
	public function getInvoiceCreateUrl()
	{
		return $this->getGeneralConfig('invoice_create_url');
	}

}