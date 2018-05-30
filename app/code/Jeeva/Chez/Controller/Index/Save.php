<?php
 
namespace Jeeva\Chez\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Jeeva\Chez\Model\CreateFactory;

class Save extends Action
{
    /**
     * @var \Tutorial\SimpleNews\Model\NewsFactory
     */
    protected $_modelNewsFactory;
 
    /**
     * @param Context $context
     * @param NewsFactory $modelNewsFactory
     */
    public function __construct(Context $context,CreateFactory $modelCreateFactory) {
    	$this->_modelCreateFactory = $modelCreateFactory;
    	parent::__construct($context);

    }
    public function execute()
    {
    	$firstname = $this->getRequest()->getPost('firstname');
    	$lastname = $this->getRequest()->getPost('lastname');
    	$middlename = $this->getRequest()->getPost('middlename');
    	$model = $this->_modelCreateFactory->create();
    	$data = array('first_name' => $firstname,
                          'last_name' => $lastname,
                          'middle_name' => $middlename,
                        );
    	$model->setData($data)->save();
    	$this->messageManager->addSuccess(
                            __('Thanks for Submission...')
                    );
    	$this->_redirect('*/*/');
        return;


    }

}

?>