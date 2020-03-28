<?php

namespace Training\Bundle\UserNamingBundle\Tests\Behat\Context;

use Behat\Mink\Element\NodeElement;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Oro\Bundle\DataGridBundle\Tests\Behat\Element\GridInterface;
use Oro\Bundle\DataGridBundle\Tests\Behat\Context\GridContext as OroGridContext;
use Oro\Bundle\TestFrameworkBundle\Behat\Element\Element;
use Oro\Bundle\TestFrameworkBundle\Behat\Element\Table;

class FeatureGridContext extends OroGridContext implements KernelAwareContext
{
    private const XPATH_CLICKABLE_TRIGGER = '//a[contains(@class, "show-hide-trigger")]';

    use KernelDictionary;

    /**
     * @When /^(?:|I )I view example on row (?P<content>(?:[^"]|\\")*) in grid$/
     * @When /^(?:|I )I view example on row (?P<content>(?:[^"]|\\")*) in grid (?P<gridName>[^"]+)$/
     *
     * @param string|null $gridName
     * @param string|null $content
     */
    public function viewExampleOnRow(?string $gridName = null, ?string $content = null): void
    {
        $triggerElement = $this->getTriggerElement($gridName, $content);
        $triggerElement->click();
    }


    /**
     * Returns click trigger element or null if not found
     *
     * @param string|null $gridName
     * @param string|null $content
     * @return NodeElement|null
     */
    private function getTriggerElement(?string $gridName = null, ?string $content = null): ?NodeElement
    {
        $grid = $this->getGrid($gridName);
        $row = $grid->getRowByContent($content);
        return $row->find('xpath', self::XPATH_CLICKABLE_TRIGGER);
    }

    /**
     * @param string|null $gridName
     * @param string|null $content
     * @return GridInterface|Table|Element
     */
    private function getGrid($gridName = null, $content = null)
    {
        if ($gridName === null) {
            $gridName = 'Grid';
        }

        if ($content !== null) {
            $grid = $this->elementFactory->findElementContains($gridName, $content);
        } else {
            $grid = $this->elementFactory->createElement($gridName);
        }

        self::assertTrue($grid->isIsset(), sprintf('Element "%s" not found on the page', $gridName));

        return $grid;
    }

}
