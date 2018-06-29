<?php
/**
* BSS Commerce Co.
*
* NOTICE OF LICENSE
*
* This source file is subject to the EULA
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://bsscommerce.com/Bss-Commerce-License.txt
*
* =================================================================
*                 MAGENTO EDITION USAGE NOTICE
* =================================================================
* This package designed for Magento COMMUNITY edition
* BSS Commerce does not guarantee correct work of this extension
* on any other Magento edition except Magento COMMUNITY edition.
* BSS Commerce does not provide extension support in case of
* incorrect edition usage.
* =================================================================
*
* @category   BSS
* @package    Bss_OrderDeliveryDate
* @author     Extension Team
* @copyright  Copyright (c) 2015-2016 BSS Commerce Co. ( http://bsscommerce.com )
* @license    http://bsscommerce.com/Bss-Commerce-License.txt
*/
namespace Bss\OrderDeliveryDate\Helper;

/**
 * Visitor Observer
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	protected $_scopeConfig;

	public function __construct(
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
		) {
		$this->_scopeConfig = $scopeConfig;
	}

	public function isEnabled() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		if($active != 1) {
			return false;
		}
		
		return true;
	}

	public function getDisplayAt() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/on_which_page', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		
		return $active;
	}

	public function getProcessingTime() {
		$process_time =  $this->_scopeConfig->getValue('orderdeliverydate/general/process_time', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		if(!$process_time) return 0;
		return $process_time;
	}

	public function getCutOffTime() {
		$cut_off_time =  $this->_scopeConfig->getValue('orderdeliverydate/general/cut_off_time', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		if(!$cut_off_time || $cut_off_time == '00,00,00') return false;
		$cut_off_time_convert = strtotime(str_replace(',',':',$cut_off_time));
		
		return $cut_off_time_convert;
	}

	public function getBlockHoliday() {
		$block_out_holidays =  $this->_scopeConfig->getValue('orderdeliverydate/general/block_out_holidays', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		$block_out_holidays_arr = unserialize($block_out_holidays);
		$response = array();
		foreach ($block_out_holidays_arr as $holidays) {
			$newDate = date("Y-m-d", strtotime($holidays['date']));
			$response[] = $newDate;
		}
		return serialize($response);
	}

	public function getTimeSlot() {
		$time_slots =  $this->_scopeConfig->getValue('orderdeliverydate/general/time_slots', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		$time_slot_arr = unserialize($time_slots);
		$result = array();
		foreach ($time_slot_arr as $time_slot) {
			$a = $time_slot['note'].' ' . $time_slot['from'] . ' - ' . $time_slot['to'];
			$b = array('value' => $a, 'label' => $a);
			array_push($result, $b);
		}
		return $result;
	}

	public function getDayOff() {
		$day_off =  $this->_scopeConfig->getValue('orderdeliverydate/general/deliverydate_day_off', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		if(!$day_off) return false;
		// $day_off_arr = explode(',', $day_off));
		return $day_off;
	}

	public function getDateFormat()
    {
        $dateFormat = $this->_scopeConfig->getValue('orderdeliverydate/general/date_fields');
        if($dateFormat){
        	switch ($dateFormat) {
        		case 1:
        			return 'mm/dd/yy';
        			break;
        		case 2:
        			return 'dd-mm-yy';
        			break;
        		case 3:
        			return 'yy-mm-dd';
        			break;
        		default:
        			return 'mm/dd/yy';
        			break;
        	}
        }
        return 'mm/dd/yy';
    }


    public function abState() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/ab_state', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			return 0;
	
	}


	public function bcState() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/bc_state', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			return 0;
	
	}

	public function mbState() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/mb_state', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			return 0;
	
	}

	public function nbState() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/nb_state', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			return 0;
	
	}

	public function nlState() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/nl_state', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			return 0;
	
	}

	public function nsState() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/ns_state', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			return 0;
	
	}


	public function ntState() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/nt_state', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			return 0;
	
	}



	public function onState() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/on_state', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			return 0;
	
	}



	public function peState() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/pe_state', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			return 0;
	
	}


	public function qcState() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/qc_state', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			return 0;
	
	}


	public function skState() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/sk_state', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			return 0;
	
	}


	public function ytState() {
		$active =  $this->_scopeConfig->getValue('orderdeliverydate/general/yt_state', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

			return 0;
	
	}


	public function getShippingState(){
		$obj = \Magento\Framework\App\ObjectManager::getInstance();
		$quote = $obj->get('Magento\Checkout\Model\Session')->getQuote();
		$shippingCity = $quote->getShippingAddress()->getRegion();
	return $shippingCity;
	}


}
