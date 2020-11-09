<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class Comment implements \JsonSerializable
{
    /**
     * @Assert\NotBlank()
     */
    private string $name;

    /**
     * @Assert\NotBlank()
     */
    private string $notes;

    private ?\DateTime $createdAt;

    private string $pageUid;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getPageUid(): string
    {
        return $this->pageUid;
    }

    public function setPageUid(string $pageUid): void
    {
        $this->pageUid = $pageUid;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'notes' => $this->notes,
            'page_uid' => $this->pageUid,
        ];
    }
}