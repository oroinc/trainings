@fixture-TrainingUserNamingBundle:UsersNamingTypesUsersFixture.yml
Feature: User Naming Types On Users
  In order to control the assignment of User Naming Types to certain Users
  As Administrator
  I am able to view and assign certain Users User Naming Types

  Scenario: I navigate to the User View Page and see
    user's User Naming Type assignment
    Given I login as administrator
    When I go to System/ User Management/ Users
    Then I should see following records in grid:
      | john_doe |
      | mike_boo |
    When I click view john_doe in grid
    Then I should see that "Naming Type View Attribute" contains "Official"
    When I move backward one page
    And I click edit john_doe in grid
    And I fill form with:
      | User Naming Type | First name only |
    And I save and close form
    Then I should see that "Naming Type View Attribute" contains "First name only"
