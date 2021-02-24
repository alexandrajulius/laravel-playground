Feature: Title of the feature
    Say something

    Scenario:
        Given I send a GET request "/api/quotes/barney"
        Then I should get the following response
        """
        json string
        """

