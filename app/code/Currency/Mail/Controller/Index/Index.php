<?php
 
namespace Currency\Mail\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Currency\Mail\Model\UserFactory;


use Magento\Framework\App\RequestInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;


class Index extends Action
{
    /**
     * @var \Tutorial\SimpleNews\Model\NewsFactory
     */
    
 
    /**
     * @param Context $context
     * @param NewsFactory $modelNewsFactory
     */
    public function __construct(Context $context,StateInterface $inlineTranslation,
TransportBuilder $transportBuilder,ScopeConfigInterface $scopeConfig,UserFactory $modelUserFactory) {

        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->_modelUserFactory = $modelUserFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {
        /**
         * When Magento get your model, it will generate a Factory class
         * for your model at var/generaton folder and we can get your
         * model by this way
         */

        
        $cny = $this->getRequest()->getPost('cny'); 
        $euro = $this->getRequest()->getPost('euro');
        $inr = $this->getRequest()->getPost('inr');
        $thb = $this->getRequest()->getPost('thb');
        $vnd = $this->getRequest()->getPost('vnd');
        $others = $this->getRequest()->getPost('others');


        if(empty($cny))
        {
            $cny_value = 'No';
        }
        else{
            $cny_value = 'Yes';

        }

        if(empty($others))
        {
            $others_value = 'No';

        }
        else{
            $others_value = 'Yes';
        }

        if(empty($euro))
        {
            $euro_value = 'No';
        }
        else{
            $euro_value = 'Yes';

        }

        if(empty($inr))
        {
            $inr_value = 'No';
        }
        else{
            $inr_value = 'Yes';

        }

        if(empty($thb))
        {
            $thb_value = 'No';
        }
        else{
            $thb_value = 'Yes';

        }

        if(empty($vnd))
        {
            $vnd_value = 'No';
        }
        else{
            $vnd_value = 'Yes';

        }

        $companyname = $this->getRequest()->getPost('company');
        $firstname = $this->getRequest()->getPost('firstname');
        $lastname = $this->getRequest()->getPost('lastname');
        $streetaddress = $this->getRequest()->getPost('streetaddress');
        $postcode = $this->getRequest()->getPost('postcode');
        $country = $this->getRequest()->getPost('country');
        $phone = $this->getRequest()->getPost('phone');
        $product_name = $this->getRequest()->getPost('product_name');

        $user_model = $this->_modelUserFactory->create();


        $data = array(
                          'company' => $companyname,
                          'firstname' => $firstname,
                          'lastname' => $lastname,
                          'streetaddress' => $streetaddress,
                          'postcode'=>$postcode,
                          'country' => $country,
                          'phone' => $phone,
                          'cny' => $cny_value,
                          'euro' => $euro_value,
                          'inr' => $inr_value,
                          'thb' => $thb_value,
                          'vnd' => $vnd_value,
                          'others' => $others_value,
                          'product_name' => $product_name
                    );

        try {
            
            $user_model->setData($data)
                       ->save();
            $general_email = $this->scopeConfig->getValue('trans_email/ident_support/email',ScopeInterface::SCOPE_STORE);
            $general_name = $this->scopeConfig->getValue('trans_email/ident_support/name',ScopeInterface::SCOPE_STORE);

            $sender = [
            'name' => $general_name,
            'email' => $general_email,
            ];
            $vars = Array('company' => $companyname,'firstname'=>$firstname,'lastname'=>$lastname, 'streetaddress'=>$streetaddress, 'postcode' =>$postcode, 'country' => $country, 'phone' =>$phone, 'product_name' =>$product_name);


            $this->inlineTranslation->suspend();
            $toEmail = array($cny,$euro,$inr,$thb,$vnd,$others);
            //$toEmail = 'testingteamtest3@gmail.com';
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->transportBuilder
               ->setTemplateIdentifier('currency_email_template')
               ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
               ->setTemplateVars($vars)
               ->setFrom($sender)
               ->addTo($toEmail)
               ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();


         
            //return 'Thanks for your submission';
               // $this->messageManager->addSuccess(
               //             __('Thanks for Your Submission')
               //     );
        }catch (\Exception $e) {
            $this->messageManager->addError(
                        __($e));
                
            }
        //$this->_redirect($url);
        return;
    }
}