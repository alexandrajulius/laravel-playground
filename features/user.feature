Feature: Citizens of Sheffield are Users
    - The names and addresses of users can be edited
    - The API can return a list of Sheffield's

    # TODO
    Scenario: The firstname of a user can be edited
        Given "barney.gumble" exists in the database
        When I want to put the following payload on "/api/citizen/update/barneygumble"
        """
        {"firstname: ":"Barney Barney"}
        """
        Then I should get "barney.gumble" with the updated data
        """
        json string
        """

    Scenario: The lastname of a a user can be edited
        Given I send a GET request "/api/citizens/lastname/gumblegumble"
        Then I should get the following response
        """
        json string
        """

    Scenario: The address of a user can be edited
        Given I send a GET request "/api/citizens/address/barney.gumble"
        Then I should get the following response
        """
        json string
        """

    Scenario: The API returns a list of Sheffield's citizens
        Given I send a GET request "/api/citizens"
        Then I should get the following response
        """
        {"1":{"firstname: ":"Edna","lastname: ":"Krabappel","address: ":"82 Evergreen Terrace Springfield"},"2":{"firstname: ":"Homer","lastname: ":"Simpson","address: ":"742 Evergreen Terrace Springfield"},"3":{"firstname: ":"Marge","lastname: ":"Simpson","address: ":"742 Evergreen Terrace Springfield"},"4":{"firstname: ":"Barney","lastname: ":"Gumble","address: ":"Moes Taverne Springfield"},"5":{"firstname: ":"Apu","lastname: ":"Nahasapeemapetilon","address: ":"Kwik-E-Mart Springfield"}}
        """

