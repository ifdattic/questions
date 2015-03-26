Feature: A visitor can view a list of questions
    In order to view a list of questions
    As a visitor
    I need to be able to get a list of questions

    Scenario: View an empty list of questions
        Given there are no questions
        When I request a list of questions
        Then I should see an empty list

    Scenario: View a list with 1 question
        Given there is a question "Who are you?"
        When I request a list of questions
        Then I should see a list of questions containing:
            | question          | tags |
            | Who are you?      |      |

    @critical
    Scenario: Questions are sorted alphabetically
        Given there is a question "Who are you?"
        And there is a question "Why?"
        And there is a question "Do you want this?"
        When I request a list of questions
        Then I should see a list of questions containing:
            | question          | tags |
            | Do you want this? |      |
            | Who are you?      |      |
            | Why?              |      |

    Scenario: View a list of questions with alphabetically sorted tags
        Given there is a question "Who are you?" with tags:
            | name         |
            | personal     |
            | jobs         |
            | achievements |
        When I request a list of questions
        Then I should see a list of questions containing:
            | question     | tags                       |
            | Who are you? | achievements,jobs,personal |
