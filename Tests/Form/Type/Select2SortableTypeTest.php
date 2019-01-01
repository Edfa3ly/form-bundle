<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\Select2SortableType;

use Thrace\FormBundle\Form\Type\Select2Type;

use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;
use Thrace\FormBundle\Form\DataTransformer\ArrayCollectionToStringTransformer;

/**
 * Class Select2SortableTypeTest
 * @package Thrace\FormBundle\Tests\Form\Type
 */
class Select2SortableTypeTest extends TextTypeTest
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create(Select2SortableType::class, null, array(
            'reference_class' => 'ReferenceClass',        
            'inversed_class' => 'InversedClass',        
            'inversed_property' => 'InversedProperty',        
        ));
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(

        ), $configs);
    }


    /**
     * @return array
     */
    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(
			        new Select2SortableType($this->getMockBuilderTransformer()),
		        )
			)
    	);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockBuilderTransformer()
    {
        return $this->getMockBuilder(ArrayCollectionToStringTransformer::class)->disableOriginalConstructor()->getMock();
    }
}