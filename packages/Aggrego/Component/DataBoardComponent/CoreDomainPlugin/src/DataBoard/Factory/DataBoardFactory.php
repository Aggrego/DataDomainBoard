<?php
declare(strict_types=1);

namespace Aggrego\Component\DataBoardComponent\CoreDomainPlugin\DataBoard\Factory;

use Aggrego\Component\BoardComponent\Domain\Board\Board;
use Aggrego\Component\BoardComponent\Domain\Board\Factory\BoardFactory;
use Aggrego\Component\BoardComponent\Domain\Board\Factory\Exception\UnprocessablePrototype;
use Aggrego\Component\BoardComponent\Domain\Board\Id\Exception\UnprocessablePrototype as IdFactoryUnprocessablePrototype;
use Aggrego\Component\BoardComponent\Domain\Board\Id\IdFactory;
use Aggrego\Component\BoardComponent\Domain\Board\Metadata;
use Aggrego\Component\BoardComponent\Domain\Board\Name;
use Aggrego\Component\BoardComponent\Domain\BoardPrototype\Prototype;
use Aggrego\Component\DataBoardComponent\CoreDomainPlugin\BoardPrototype\DataPrototype;
use Aggrego\Component\DataBoardComponent\CoreDomainPlugin\DataBoard\DataBoard;

class DataBoardFactory implements BoardFactory
{
    /**
     * @inheritDoc
     */
    public function build(IdFactory $factory, Prototype $prototype): Board
    {
        if ($prototype->getName()->getValue() !== DataPrototype::NAME) {
            throw new UnprocessablePrototype(
                sprintf('Expected prototype %s, got %s', DataPrototype::NAME, $prototype->getName()->getValue())
            );
        }

        try {
            $newId = $factory->generateNew($prototype);
        } catch (IdFactoryUnprocessablePrototype $e) {
            throw new UnprocessablePrototype(
                'Invalid prototype. Unable render new key',
                0,
                $e
            );
        }

        return new DataBoard(
            $newId,
            new Name($prototype->getName()->getValue()),
            $prototype->getProfileName(),
            new Metadata($prototype->getMetadata()->getValue())
        );
    }
}
