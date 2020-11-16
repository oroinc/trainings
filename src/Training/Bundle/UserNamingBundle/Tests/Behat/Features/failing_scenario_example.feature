Feature: Calendar Events grid
  In order to have all information about calendar events
  As admin
  I see events available in events grid

  Scenario: Calendar Event with link to organizer profile is present in the grid
    Given I login as administrator
    And go to Activities/ Calendar Events
    And I click View "Call to client" in grid
    And I should see Call to client with:
      | Organizer | Charlie Sheen |
