<?php
declare(strict_types=1);

namespace Aggrego\Component\DataBoardComponent\CoreDomainPlugin\BoardPrototype;

use Aggrego\Component\BoardComponent\Domain\Board\Id\Id;
use Aggrego\Component\BoardComponent\Domain\BoardPrototype\Exception\MissingParentId;
use Aggrego\Component\BoardComponent\Domain\BoardPrototype\Metadata;
use Aggrego\Component\BoardComponent\Domain\BoardPrototype\Name;
use Aggrego\Component\BoardComponent\Domain\BoardPrototype\Prototype;
use Aggrego\Component\BoardComponent\Domain\Profile\Name as ProfileName;

class DataPrototype implements Prototype
{
    public const NAME = 'data_board';

    public function __construct(
        private ProfileName $name,
        private Metadata $metadata,
        private ?Id $parentId
    ) {
    }

    public function getName(): Name
    {
        return new Name(self::NAME);
    }

    public function getProfileName(): ProfileName
    {
        return $this->name;
    }

    public function getMetadata(): Metadata
    {
        return $this->metadata;
    }

    public function hasParentId(): bool
    {
        return !is_null($this->parentId);
    }

    /**
     * @inheritDoc
     */
    public function getParentId(): Id
    {
        if (!$this->hasParentId()) {
            throw new MissingParentId();
        }
        return $this->parentId;
    }
}
