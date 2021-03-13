Feature: Quotes of authors can be requested and added
    - The API can return a list of quotes for an author
    - A quote can be added for an author

    Scenario: The API returns a list of quotes for an author
        Given "rudyard.kipling" exists in the database
        And I send a GET request "/api/quotes/leo.tolstoy"
        Then I should get the following response
        """
        {"leo.tolstoy":{"Anna Karenina":["All happy families are alike; each unhappy family is unhappy in its own way.","Respect was invented to cover the empty place where love should be."],"War and Peace":["We can know only that we know nothing. And that is the highest degree of human wisdom."]}}
        """

    Scenario: A quote can be added for an author
        Given I want to add a quote with the following properties
            | AUTHOR USERNAME | QUOTE                                                                 | BOOK                |
            | douglas.adams   | I love deadlines. I love the whooshing noise they make as they go by. | The Salmon of Doubt |
        Then the quote should be added to the author's quotations

