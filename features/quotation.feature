Feature: Quotes of authors can be requested and added
    - The API can return a list of quotes for an author
    - A quote can be added for an author

    Scenario: The API returns a list of quotes for an author
        Given "rudyard.kipling" exists in the database
        And I send a GET request "/api/quotes/rudyard.kipling"
        Then I should get the following response
        """
        {"rudyard.kipling":["For Kim did nothing with an immense success.","Those who beg in silence starve in silence."]}
        """

    Scenario: A quote can be added for an author
        Given I want to add a quote with the following properties
            | AUTHOR USERNAME | QUOTE                                                                 | BOOK                |
            | douglas.adams   | I love deadlines. I love the whooshing noise they make as they go by. | The Salmon of Doubt |
        Then the quote should be added to the author's quotations

