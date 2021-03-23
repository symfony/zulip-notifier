<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Notifier\Bridge\Zulip\Tests;

use Symfony\Component\Notifier\Bridge\Zulip\ZulipTransportFactory;
use Symfony\Component\Notifier\Test\TransportFactoryTestCase;
use Symfony\Component\Notifier\Transport\TransportFactoryInterface;

final class ZulipTransportFactoryTest extends TransportFactoryTestCase
{
    /**
     * @return ZulipTransportFactory
     */
    public function createFactory(): TransportFactoryInterface
    {
        return new ZulipTransportFactory();
    }

    public function createProvider(): iterable
    {
        yield [
            'zulip://host.test?channel=testChannel',
            'zulip://email:token@host.test?channel=testChannel',
        ];
    }

    public function supportsProvider(): iterable
    {
        yield [true, 'zulip://host?channel=testChannel'];
        yield [false, 'somethingElse://host?channel=testChannel'];
    }

    public function incompleteDsnProvider(): iterable
    {
        yield 'missing email or token' => ['zulip://testOneOfEmailOrToken@host.test?channel=testChannel'];
    }

    public function missingRequiredOptionProvider(): iterable
    {
        yield 'missing option: channel' => ['zulip://email:token@host'];
    }

    public function unsupportedSchemeProvider(): iterable
    {
        yield ['somethingElse://email:token@host?channel=testChannel'];
        yield ['somethingElse://email:token@host']; // missing "channel" option
    }
}
