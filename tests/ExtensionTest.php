<?php

namespace Tests;

use Pear\OpenId\Exceptions\OpenIdExtensionException;
use Pear\OpenId\Extensions\OpenIdExtension;
use Pear\OpenId\OpenIdMessage;
use PHPUnit\Framework\TestCase;
use Tests\Extension\MockExtension;
use Tests\Extension\MockExtensionInvalidAlias;
use Tests\Extension\MockExtensionNoResponseKeys;

/**
 * OpenIdExtensionTest
 *
 * PHP Version 5.2.0+
 *
 * @uses      PHPUnit_Framework_TestCase
 * @category  Auth
 * @package   OpenID
 * @author    Bill Shupp <hostmaster@shupp.org>
 * @copyright 2009 Bill Shupp
 * @license   http://www.opensource.org/licenses/bsd-license.php FreeBSD
 * @link      http://github.com/shupp/openid
 */

/**
 * OpenIdExtensionTest
 *
 * Test class for OpenIdExtension.
 * Generated by PHPUnit on 2009-04-29 at 00:48:40.
 *
 * @uses      PHPUnit_Framework_TestCase
 * @category  Auth
 * @package   OpenID
 * @author    Bill Shupp <hostmaster@shupp.org>
 * @copyright 2009 Bill Shupp
 * @license   http://www.opensource.org/licenses/bsd-license.php FreeBSD
 * @link      http://github.com/shupp/openid
 */
class ExtensionTest extends TestCase
{
    /**
     * @var    OpenIdExtension
     * @access protected
     */
    protected $object;

    protected function setUp(): void
    {
        $this->object = new MockExtension(OpenIdExtension::REQUEST);
    }

    protected function tearDown(): void
    {
        unset($this->object);
    }

    public function testConstructorFailure()
    {
        $this->expectException(OpenIdExtensionException::class);
        $object = new MockExtension('bogus');
    }

    public function testConstructorWithMessage()
    {
        $key     = 'four';
        $value   = '4';
        $message = new OpenIdMessage();
        $message->set('openid.ns.mock', 'http://example.com/mock');
        $message->set("openid.mock.$key", $value);
        $this->object = new MockExtension(OpenIdExtension::REQUEST, $message);
        $this->assertSame($value, $this->object->get($key));
    }

    public function testSetAndGet()
    {
        $this->object->set('one', 'bar');
        $this->assertSame('bar', $this->object->get('one'));
        $this->assertNull($this->object->get('fubar'));
    }

    public function testSetFailure()
    {
        $this->expectException(OpenIdExtensionException::class);
        $this->object->set('bogus', 'bar');
    }

    public function testToMessage()
    {
        $this->object->set('one', 'foo');
        $message = new OpenIdMessage;
        $this->assertNotSame('foo', $message->get('openid.mock.one'));
        $this->object->toMessage($message);
        $this->assertSame('foo', $message->get('openid.mock.one'));
    }

    public function testFromMessageResponse()
    {
        $this->object = new MockExtension(OpenIdExtension::RESPONSE);
        $this->object->set('four', 'foo');
        $message = new OpenIdMessage;
        $this->assertNotSame('foo', $message->get('openid.mock.four'));
        $this->object->toMessage($message);
        $values = $this->object->fromMessageResponse($message);
        $this->assertSame($values['four'], $message->get('openid.mock.four'));
    }

    public function testToMessageFailureInvalidAlias()
    {
        $this->expectException(OpenIdExtensionException::class);
        $extension = new MockExtensionInvalidAlias(
            OpenIdExtension::RESPONSE
        );

        $message = new OpenIdMessage;
        $extension->toMessage($message);
    }

    public function testToMessageFailureAliasCollide()
    {
        $this->expectException(OpenIdExtensionException::class);
        $extension = new MockExtension(OpenIdExtension::RESPONSE);
        $message   = new OpenIdMessage;
        $message->set('openid.ns.mock', 'foo');
        $extension->toMessage($message);
    }

    public function testFromMessageReponseFailure()
    {
        $extension = new MockExtension(OpenIdExtension::RESPONSE);
        $message   = new OpenIdMessage;
        // Make sure we iterate over the message at least once
        $message->set('openid.ns.foo', 'bar');
        $response = $extension->fromMessageResponse($message);
        $this->assertSame(0, count($response));
    }

    public function testFromMessageReponseNoResponseKeys()
    {
        $extension = new MockExtensionNoResponseKeys(
            OpenIdExtension::RESPONSE
        );

        $message = new OpenIdMessage;
        // Make sure we iterate over the message at least once
        $message->set('openid.ns.mock', 'http://example.com/mock');
        $message->set('openid.mock.foo', 'bar');
        $response = $extension->fromMessageResponse($message);
        $this->assertSame(1, count($response));
    }

    public function testGetNameSpace()
    {
        $this->assertSame($this->object->getNamespace(), 'http://example.com/mock');
    }
}