<?php

namespace Category\Attributes\Model\Category\Attribute\Source;
use School\Creation\Model\CreateFactory;



class SchoolName extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    protected $_optionsData;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options,CreateFactory $modelCreateFactory)
    {
        $this->_modelCreateFactory = $modelCreateFactory;
        $this->_optionsData = $options;
    }

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {

        $school_model = $this->_modelCreateFactory->create();
        $data = $school_model->getCollection()->getData();
        $value1 = array();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $collection = $objectManager->create('School\Creation\Model\Create');
        $option = $collection->getCollection();
        $optionsArray =[];
        foreach($option as $optionValues) { 
          $optionsArray [] = [
            'label' =>  $optionValues['school_name'],
            'value' => $optionValues['school_id']
        ];
        }
        return $optionsArray;
    }
}
