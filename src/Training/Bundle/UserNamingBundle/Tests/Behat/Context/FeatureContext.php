<?php

namespace Training\Bundle\UserNamingBundle\Tests\Behat\Context;

use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Oro\Bundle\DataGridBundle\Tests\Behat\Element\GridInterface;
use Oro\Bundle\DataGridBundle\Tests\Behat\Context\GridContext;
use Oro\Bundle\TestFrameworkBundle\Behat\Element\Element;
use Oro\Bundle\TestFrameworkBundle\Behat\Element\Table;

class FeatureContext extends GridContext implements KernelAwareContext
{
    private const XPATH_CLICKABLE_TRIGGER = '//a[contains(@class, "show-hide-trigger")]';

    use KernelDictionary;

    /**
     * Checks if clickable example is available on grid
     *
     * @Given /^(?:|I )Row (?P<content>(?:[^"]|\\")*) has clickable example link on the grid (?P<gridName>[^"]+)$/
     * @Given /^(?:|I )Row (?P<content>(?:[^"]|\\")*) has clickable example link on the grid$/
     *
     * @param string|null $gridName
     * @param string|null $content
     */
    public function seeClickableExampleOnRow($gridName = null, $content = null)
    {
        $grid = $this->getGrid($gridName);
        $row = $grid->getRowByContent($content);
        $triggerElement = $row->find('xpath', self::XPATH_CLICKABLE_TRIGGER);

        self::assertNotNull($triggerElement, sprintf(
            'The clickable example link was not found for row %s',
            $content
        ));
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
