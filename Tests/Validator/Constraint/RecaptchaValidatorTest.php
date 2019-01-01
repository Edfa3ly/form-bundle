<?php
namespace Thrace\FormBundle\Tests\Validator\Constraint;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ServerBag;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RequestStack;
use Thrace\ComponentBundle\Test\Tool\BaseTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Thrace\FormBundle\Validator\Constraint\Recaptcha;
use Symfony\Component\Validator\Context\ExecutionContext;
use Thrace\FormBundle\Validator\Constraint\RecaptchaValidator;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

/**
 * Class RecaptchaValidatorTest
 * @package Thrace\FormBundle\Tests\Validator\Constraint
 */
class RecaptchaValidatorTest extends BaseTestCase
{
    
    public function testNullIsValid()
    {
        $context =  $this->getMockBuilder(ExecutionContext::class)->disableOriginalConstructor()->getMock();
        $validator = new RecaptchaValidator($this->getRequestMock(), array(
            'public_key' => 'xxx',
            'private_key' => 'xxx'
        ));
        
        $validator->initialize($context);
        $context->expects($this->once())
            ->method('addViolation');

        $validator->validate(null, new Recaptcha());
    }

    /**
     *
     */
    public function testDataIsValid()
    {
        $context =  $this->getMockBuilder(ExecutionContext::class)->disableOriginalConstructor()->getMock();
        $validator = new RecaptchaValidator($this->getRequestMock(), array(
            'public_key' => 'xxx',
            'private_key' => 'xxx',
            'verify_url' => 'http://www.google.com/recaptcha/api/verify'
        ));
        
        $validator->initialize($context);
        
        $context->expects($this->once())
            ->method('addViolation');

         $validator->validate('data', new Recaptcha());
    }
    
    
    protected function getRequestMock($param = null)
    {
        $fakeRequest = Request::create('/', 'GET');

        $fakeRequest->setSession(new Session(new MockArraySessionStorage()));
        $requestStack = new RequestStack();
        $requestStack->push($fakeRequest);

        return $requestStack;
    }

    /**
     * @param $param
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getParameterBagMock($param)
    {
        $mock =  $this->getMockBuilder(ParameterBag::class)->disableOriginalConstructor()->getMock();
        $mock->expects($this->any())->method('get')->will($this->returnValue($param));
        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getServerBagMock()
    {
        $mock =  $this->getMockBuilder(ServerBag::class)->disableOriginalConstructor()->getMock();
        $mock->expects($this->any())->method('get')->will($this->returnValue('http://thrace.local/'));
        return $mock;
    }
}