<?php

declare(strict_types=1);

namespace SonsOfPHP\Component\EventSourcing\Tests;

use SonsOfPHP\Component\EventSourcing\AggregateVersion;
use SonsOfPHP\Component\EventSourcing\AggregateVersionInterface;
use SonsOfPHP\Component\EventSourcing\EventSourcingException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class AggregateVersionTest extends TestCase
{
    public function testItHasTheRightInterface(): void
    {
        $version = AggregateVersion::zero();
        $this->assertInstanceOf(AggregateVersionInterface::class, $version);

        $version = AggregateVersion::fromInt(99);
        $this->assertInstanceOf(AggregateVersionInterface::class, $version);
    }

    public function testFromInt(): void
    {
        $version = AggregateVersion::fromInt(1);

        $this->assertSame(1, $version->toInt());
    }

    public function testZero(): void
    {
        $version = AggregateVersion::zero();

        $this->assertSame(0, $version->toInt());
    }

    public function testNext(): void
    {
        $v1 = AggregateVersion::zero()->next();
        $this->assertSame(1, $v1->toInt());

        $v2 = $v1->next();
        $this->assertSame(1, $v1->toInt());
        $this->assertSame(2, $v2->toInt());
    }

    public function testPrev(): void
    {
        $version = AggregateVersion::zero()->next()->prev();

        $this->assertSame(0, $version->toInt());
    }

    public function testEquals(): void
    {
        $versionA = AggregateVersion::zero();
        $versionB = AggregateVersion::zero();

        $this->assertTrue($versionA->equals($versionB));
        $this->assertTrue($versionB->equals($versionA));
    }

    public function testInvalidVersion(): void
    {
        $this->expectException(EventSourcingException::class);

        $version = AggregateVersion::fromInt(-1);
    }
}
