<?php

namespace Training\Bundle\UserNamingBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Attribute\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Attribute\ConfigField;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityInterface;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityTrait;

#[ORM\Entity]
#[ORM\Table(name: 'training_user_naming_type')]
#[Config(
    routeName: 'training_user_naming_index',
    routeView: 'training_user_naming_view',
    defaultValues: [
        'entity' => ['icon' => 'fa-child'],
        'security' => ['type' => 'ACL', 'group_name' => '', 'category' => 'account_management']
    ]
)]
class UserNamingType implements ExtendEntityInterface
{
    use ExtendEntityTrait;

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ConfigField(
        defaultValues: [
            'importexport' => ['order' => 10],
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(name: 'title', type: Types::STRING, length: 64, nullable: false)]
    #[ConfigField(
        defaultValues: [
            'importexport' => ['order' => 20, 'identity' => true],
        ]
    )]
    private ?string $title = null;

    /**
     * Allowed placeholders are: PREFIX, FIRST, MIDDLE, LAST, SUFFIX
     */
    #[ORM\Column(name: 'format', type: Types::STRING, length: 255, nullable: false)]
    #[ConfigField(
        defaultValues: [
            'importexport' => ['order' => 30],
        ]
    )]
    private ?string $format = null;

    /**
     * Auto-generated example of name
     */
    #[ORM\Column(name: 'example', type: Types::STRING, length: 255, nullable: true)]
    #[ConfigField(
        defaultValues: [
            'importexport' => ['excluded' => true],
        ]
    )]
    private ?string $example = null;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return $this
     */
    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getExample()
    {
        return $this->example;
    }

    /**
     * @param string $example
     * @return $this
     */
    public function setExample($example): self
    {
        $this->example = $example;

        return $this;
    }

    public function __toString(): string
    {
        return (string)$this->title;
    }
}
