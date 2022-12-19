<?php

namespace Training\Bundle\UserNamingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Symfony\Component\Validator\Constraints as Assert;
use Training\Bundle\UserNamingBundle\Model\ExtendUserNamingType;

/**
 * UserNamingType contains different formats for User full name representation
 *
 * @ORM\Entity()
 * @ORM\Table(name="training_user_naming_type")
 * @Config(
 *     defaultValues={
 *          "security"={
 *              "type"="ACL",
 *              "group_name"="",
 *              "category"="user_naming_management"
 *          }
 *     }
 * )
 */
class UserNamingType extends ExtendUserNamingType
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int|null $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     */
    private string|null $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private string|null $format;

    /**
     * @return int|null
     */
    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int|null $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): string|null
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return UserNamingType
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFormat(): string|null
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return UserNamingType
     */
    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }
}
