<?php
/**
 *
 * This file is part of the Aggrego.
 * (c) Tomasz Kunicki <kunicki.tomasz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

declare(strict_types=1);

namespace Aggrego\Component\DataBoardComponent\Contract\DataBoard\Events;

use Aggrego\Component\DataBoardComponent\CoreDomainPlugin\DataBoard\DataBoard;
use Aggrego\Infrastructure\Contract\Event\CreatedAt;
use Aggrego\Infrastructure\Contract\Event\Domain;
use Aggrego\Infrastructure\Contract\Event\Name;
use Aggrego\Infrastructure\Contract\Event\Payload;
use Aggrego\Infrastructure\Contract\Event\Shared\BasicEvent;
use Aggrego\Infrastructure\Contract\Event\Version;
use DateTimeImmutable;
use TimiTao\ValueObject\Standard\Required\AbstractClass\DateTime\DateFormatValueObject;
use TimiTao\ValueObject\Standard\Required\AbstractClass\ValueObject\ArrayValueObject;
use TimiTao\ValueObject\Standard\Required\AbstractClass\ValueObject\StringValueObject;

class BoardCreatedEvent extends BasicEvent
{
    private const DOMAIN_NAME = 'board.data_board';

    public static function build(DataBoard $board): self
    {
        $domainName = sprintf('%s.%s', self::DOMAIN_NAME, $board->getId()->getValue());
        $payload = [
            'id' => $board->getId()->getValue(),
            'board_name' => $board->getName()->getValue(),
            'profile' => (string)$board->getProfileName(),
            'metadata' => $board->getMetadata()->getValue()
        ];
        return new self(
            new class($domainName) extends StringValueObject implements Domain {
            },
            new class(self::DOMAIN_NAME . '.board_created') extends StringValueObject implements Name {
            },
            new class(new DateTimeImmutable()) extends DateFormatValueObject implements CreatedAt {
            },
            new class('1.0.0.0') extends StringValueObject implements Version {
            },
            new class($payload) extends ArrayValueObject implements Payload {
            },
        );
    }
}
