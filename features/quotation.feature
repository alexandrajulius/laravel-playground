Feature: Quotations of Sheffield's citizens
    - The API can return a list of quotes for a citizen
    - A quote can be added for a citizen

    Scenario: The API returns a list of quotes for a citizen
        Given "barney.gumble" exists in the database
        And I send a GET request "/api/quotes/barney.gumble"
        Then I should get the following response
        """
        {"barney.gumble":{"quotes: ":"We want chilly-willy! We want chilly-willy!"}}
        """

    Scenario: A quote can be added for a citizen
        Given I want to add the quote "Burp" to the quotations of "barney.gumble"
        Then the quote should be added to the citizen's quotations
