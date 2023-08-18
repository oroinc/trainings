<?php

namespace Training\Bundle\UserNamingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Training\Bundle\UserNamingBundle\Model\ExtendUserNamingType;

/**
 * @ORM\Entity()
 * @ORM\Table(name="training_user_naming_type")
 * @Config(
 *      defaultValues={
 *          "entity"={
 *              "icon"="fa-child"
 *          }
 *      }
 * )
 */
class UserNamingType extends ExtendUserNamingType
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    private $title;

    /**
     * @var string
     * Allowed placeholders are: PREFIX, FIRST, MIDDLE, LAST, SUFFIX
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $format;

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
}
