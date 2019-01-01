<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Symfony\Component\Form\Tests\Extension\Core\Type\CollectionTypeTest;
use Thrace\FormBundle\Form\Type\MultiSelectCollectionType;
use Thrace\FormBundle\Form\Type\MultiSelectType;
use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;
use Thrace\DataGridBundle\DataGrid\DataGridInterface;
use Thrace\FormBundle\Form\DataTransformer\DoctrineORMTransformer;

/**
 * Class MultiSelectCollectionTypeTest
 * @package Thrace\FormBundle\Tests\Form\Type
 */
class MultiSelectCollectionTypeTest extends CollectionTypeTest
{

    protected function setUp()
    {   
        parent::setUp();
        
        if (!interface_exists('Thrace\DataGridBundle\DataGrid\DataGridInterface')) {
            $this->markTestSkipped('DataGridBundle is not available');
        }
    }
    
    public function testDefaultConfigs()
    {
        $form = $this->factory->create(MultiSelectCollectionType::class, null, array(
            'grid' => $this->createMockDataGrid(),
            'data_class' => 'Thrace\FormBundle\Tests\Fixture\Entity\Product',
        ));
        
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array('datagrid_exists' => true), $configs);
    }
    
    public function testWithInvalidDataGrid()
    {
        $this->expectException('InvalidArgumentException');
        $form = $this->factory->create(MultiSelectCollectionType::class, null, array(
            'grid' => new \stdClass(),      
        ));
        
        $form->createView();
    }
    
    public function testWithInvalidMethodIsMultiSelectEnabled()
    {
        $this->expectException('InvalidArgumentException');
        $form = $this->factory->create(MultiSelectCollectionType::class, null, array(
            'grid' => $this->createMockDataGrid(false),      
        ));
        
        $form->createView();
    }
    
    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(
			        new MultiSelectCollectionType(true),
				    new MultiSelectType($this->createMockTransformer())
		        )
			)
    	);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockTransformer()
    {
        $mock =  $this->getMockBuilder(DoctrineORMTransformer::class)->disableOriginalConstructor()->getMock();
        $mock
            ->expects($this->any())
            ->method('setClass')
            ->with('Thrace\FormBundle\Tests\Fixture\Entity\Product');
        return $mock;
    }

    /**
     * @param bool $multiSelectSortableEnabled
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockDataGrid($multiSelectSortableEnabled = true)
    {
        $mock =  $this->getMockBuilder(DataGridInterface::class)->disableOriginalConstructor()->getMock();
        $mock
            ->expects($this->any())
            ->method('isMultiSelectEnabled')
            ->will($this->returnValue($multiSelectSortableEnabled));
        return $mock;
    }
}