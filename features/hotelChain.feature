Feature:
  As a user
  I want to test if I get a list of hotels for a hotel chain

  Scenario: Getting all the hotels for a hotel chain
    When I request "/api/v1/chains/2a964bb8-58c9-4c4d-9ca5-b4234b4329dc/hotels" using HTTP GET
    Then the response code is 200
    Then the response body contains JSON:
    """
      [
          {
              "id": "3c848009-8172-4373-9635-0c3153601ba6",
              "name": "Hotel Alexanderplatz",
              "address": "Alexanderplatz 1, 10409, Berlin",
              "rooms": 150
          },
          {
              "id": "e45428c5-7cd7-4ae8-ab06-5535030d0933",
              "name": "Hotel Alexanderplatz",
              "address": "Alexanderplatz 1, 10409, Berlin",
              "rooms": 150
          }
      ]
    """

  Scenario: (Bonus) Getting all the hotel chains
    When I request "/api/v1/chains" using HTTP GET
    Then the response code is 200
    Then the response body contains JSON:
    """
      [
          {
              "id": "2a964bb8-58c9-4c4d-9ca5-b4234b4329dc",
              "name": "Blockchain"
          }
      ]
    """
