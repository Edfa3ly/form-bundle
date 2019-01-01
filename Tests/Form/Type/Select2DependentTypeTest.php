<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;
use Thrace\FormBundle\Form\Type\Select2DependentType;
use Thrace\FormBundle\Form\Type\Select2Type;
use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class Select2DependentTypeTest
 * @package Thrace\FormBundle\Tests\Form\Type
 */
class Select2DependentTypeTest extends TextTypeTest
{

    public function testDefaultConfigs()
    {
        $formConfiguration =  array('choices' => array('value1' => 'label1', 'value2' => 'label2'), 'dependent_source' => 'ajax_route');
        $form    = $this->factory->create(Select2DependentType::class, null, $formConfiguration);
        $view    = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'dependent_value' => null,
            'first_name' => 'first_name',
            'second_name' => 'second_name',
            'dependent_source' => 'ajax_route',
            'multiple' => false,
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
                    new Select2Type($this->getMockTransformer(), ChoiceType::class),
                    new Select2DependentType(),
		        )
			)
    	);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockTransformer()
    {
        return $this->getMockBuilder(DataTransformerInterface::class)->disableOriginalConstructor()->getMock();
    }
}