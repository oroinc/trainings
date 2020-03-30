Feature: Calendar Events with unknown step empty grid
  If there are no calendar events
  As admin
  I see no events available in events grid

  Scenario: Calendar Event with link to organizer profile is present in the grid
    Given I login as administrator
    When I go to Activities/ Calendar Events
    And I execute an unknown step
    Then there is no records in grid
