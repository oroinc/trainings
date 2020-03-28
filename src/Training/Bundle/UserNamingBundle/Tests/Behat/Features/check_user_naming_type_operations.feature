Feature: User Naming Types Operations
  In order to control the available User Naming Types via Management Console
  As Administrator
  I am able to see the system available User Naming Types in form of a grid

  Scenario: I navigate to the User Naming Types grid and see
    all the records on the grid with view/delete actions only
    Given I login as administrator
    When I go to System/ User Management/ User Naming Types
    Then I should see following grid:
      | Title           | Naming Format                         |
      | Official        | ID=1: PREFIX FIRST MIDDLE LAST SUFFIX |
      | Unofficial      | ID=2: FIRST LAST                      |
      | First name only | ID=3: FIRST                           |
    And I should see only following actions for row #1 on grid:
      | View   |
      | Delete |


  Scenario: In order to easily access naming format example,
    An example button is available on each of the rows in the Naming Format column
    Given I should not see "Example: Mr. John M Doe Jr."
    When I view example on row Official in grid
    Then I should see "Example: Mr. John M Doe Jr."

  Scenario: On the User Naming Format details page, one should see general information containing
    certain elements
    Given I click view Official in grid
    Then I should see that "Naming Type Attribute Title" contains "Official"
    And I should see that "Naming Type Attribute Format" contains "PREFIX FIRST MIDDLE LAST SUFFIX"
    And I should see that "Naming Type Attribute Example" contains "Mr. John M Doe Jr."

