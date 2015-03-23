Feature: A visitor can view a list of tags
    In order to view a list of tags
    As a visitor
    I need to be able to get a list of tags

    Scenario: View an empty list of tags
        Given there are no tags
        When I request a list of tags
        Then I should see an empty list

    Scenario: View a list with 1 tag
        Given there is a tag "jobs"
        When I request a list of tags
        Then I should see a list of tags containing:
            | name |
            | jobs |

    Scenario: Tags are sorted alphabetically
        Given there is a tag "jobs"
        And there is a tag "productivity"
        And there is a tag "achievements"
        When I request a list of tags
        Then I should see a list of tags containing:
            | name         |
            | achievements |
            | jobs         |
            | productivity |
