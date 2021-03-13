Feature: Author related data can be requested and edited
    - The names and countries of authors can be edited
    - The API can return a list of authors

    Scenario: The names and books of an author can be edited
        Given "leo.tolstoy" exists in the database
        When I want to put the following payload on "/api/author/update/leo.tolstoy"
        """
        {"firstname":"Lev Nikolayevich","surname":"Tolstoy","country":"Russian Federation"}
        """
        Then I should get "leo.tolstoy" with the updated data

    Scenario: The API returns a list of authors
        Given I send a GET request "/api/authors"
        Then I should get the following response
        """
        {"1":{"firstname":"Leo","surname":"Tolstoy","country":"Russia"},"2":{"firstname":"Douglas","surname":"Adams","country":"England"},"3":{"firstname":"Toni","surname":"Morrison","country":"U.S."},"4":{"firstname":"Jane","surname":"Austin","country":"England"},"5":{"firstname":"Rudyard","surname":"Kipling","country":"India"}}
        """

