<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\Tests\Component\Delivery;

use Sonata\Component\Delivery\FreeDelivery;
use Sonata\Component\Delivery\Pool;
use Sonata\ProductBundle\Entity\BaseDelivery;

class DeliveryTest extends \PHPUnit_Framework_TestCase
{
    public function testPool()
    {
        $pool = new Pool;

        $delivery = new FreeDelivery(true);
        $delivery->setCode('free_1');

        $pool->addMethod($delivery);

        $delivery = new FreeDelivery(true);
        $delivery->setCode('free_2');

        $pool->addMethod($delivery);

        $delivery = new FreeDelivery(true);
        $delivery->setCode('free_2');  // same code

        $pool->addMethod($delivery);

        $this->assertEquals(2, count($pool->getMethods()), 'Pool return 2 elements');
        $this->assertInstanceOf('Sonata\\Component\\Delivery\\FreeDelivery', $pool->getMethod('free_2'), 'Pool return an FreeDelivery Instance');
    }

    public function testGetStatusList()
    {
        $statusList = array(
            BaseDelivery::STATUS_OPEN      => 'status_open',
            BaseDelivery::STATUS_PENDING   => 'status_pending',
            BaseDelivery::STATUS_VALIDATED => 'status_validated',
            BaseDelivery::STATUS_CANCELLED => 'status_cancelled',
            BaseDelivery::STATUS_ERROR     => 'status_error',
            BaseDelivery::STATUS_STOPPED   => 'status_stopped',
        );

        $this->assertEquals($statusList, BaseDelivery::getStatusList());
    }

    public function testGetOption()
    {
        $delivery = new FreeDelivery(true);

        $delivery->setOptions(array('option1' => 'value1'));

        $this->assertEquals('value1', $delivery->getOption('option1'));
        $this->assertEquals('default', $delivery->getOption('unexisting', 'default'));
        $this->assertNull($delivery->getOption('unexisting'));
    }

}
