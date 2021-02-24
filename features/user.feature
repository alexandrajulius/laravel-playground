Feature: Citizens of Sheffield are Users
    - The names and addresses of users can be edited
    - The API can return a list of Sheffield's

    Scenario: The names and addresses of a user can be edited
        Given "barney.gumble" exists in the database
        When I want to put the following payload on "/api/citizen/update/barney.gumble"
        """
        {"firstname":"Barney","surname":"Krabappel","address":"82 Evergreen Terrace Springfield"}
        """
        Then I should get "barney.gumble" with the updated data

    Scenario: The API returns a list of Sheffield's citizens
        Given I send a GET request "/api/citizens"
        Then I should get the following response
        """
        {"1":{"firstname: ":"Edna","surname: ":"Krabappel","address: ":"82 Evergreen Terrace Springfield"},"2":{"firstname: ":"Homer","surname: ":"Simpson","address: ":"742 Evergreen Terrace Springfield"},"3":{"firstname: ":"Marge","surname: ":"Simpson","address: ":"742 Evergreen Terrace Springfield"},"4":{"firstname: ":"Barney","surname: ":"Gumble","address: ":"Moes Taverne Springfield"},"5":{"firstname: ":"Apu","surname: ":"Nahasapeemapetilon","address: ":"Kwik-E-Mart Springfield"}}
        """

