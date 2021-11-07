<?php
declare(strict_types=1);

namespace Aggrego\Component\DataBoardComponent\CoreDomainPlugin\DataBoard;

use Aggrego\Component\BoardComponent\Domain\Board\Board;
use Aggrego\Component\BoardComponent\Domain\Board\Id\Id;
use Aggrego\Component\BoardComponent\Domain\Board\Metadata;
use Aggrego\Component\BoardComponent\Domain\Board\Name;
use Aggrego\Component\BoardComponent\Domain\BoardPrototype\Prototype;
use Aggrego\Component\BoardComponent\Domain\Profile\KeyChange;
use Aggrego\Component\BoardComponent\Domain\Profile\Name as ProfileName;
use Aggrego\Component\BoardComponent\Domain\Profile\Transformation\TransformationProfile;
use Aggrego\Component\DataBoardComponent\Contract\DataBoard\Events\BoardCreatedEvent;
use Aggrego\Infrastructure\Contract\Event\Event;

class DataBoard implements Board
{
    /** @var array<Event> */
    private array $events = [];

    public function __construct(
        private Id $id,
        private Name $boardName,
        private ProfileName $profileName,
        private Metadata $metadata
    ) {
        $this->events[] = BoardCreatedEvent::build($this);
    }

    /** @return array<Event> */
    public function getEvents(): array
    {
        return $this->events;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->boardName;
    }

    public function getProfileName(): ProfileName
    {
        return $this->profileName;
    }

    public function getMetadata(): Metadata
    {
        return $this->metadata;
    }

    /**
     * {@inheritDoc}
     */
    public function transform(KeyChange $key, TransformationProfile $transformation): Prototype
    {
        return $transformation->transform($key, $this);
    }
}
