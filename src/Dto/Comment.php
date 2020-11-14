<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;

class Comment
{
    /**
     * @Assert\NotBlank()
     * @SerializedName("name")
     */
    private string $name;

    /**
     * @Assert\NotBlank()
     * @SerializedName("notes")
     */
    private string $notes;

    /**
     * @SerializedName("created_at")
     */
    private ?\DateTimeInterface $createdAt;

    /**
     * @SerializedName("page_uid")
     */
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
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
}