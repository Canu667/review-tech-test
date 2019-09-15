Feature:
  In order to have a great Hotel API
  As a API user
  I want to test the following scenarios

  Scenario: Getting the hotel average review score
    When I request "/api/v1/reviews/1f451fb2-8ee5-4716-8ba2-dc308f6d842e/average" using HTTP GET
    Then the response code is 200
    Then the response body contains JSON:
    """
    {
      "avg": "6.25"
    }
    """

  Scenario: Getting the hotel average review score for the non-existing hotel
    When I request "/api/v1/reviews/some-dummy-uuid-wannabe/average" using HTTP GET
    Then the response code is 404

  Scenario: Getting the hotel reviews
    When I request "/api/v1/hotels/1f451fb2-8ee5-4716-8ba2-dc308f6d842e/reviews" using HTTP GET
    Then the response code is 200
    Then the response body contains JSON:
    """
      [
          {
              "id": "16972d64-cb8d-4484-81f9-4ec39969b1da",
              "text": "Very nice stay",
              "createdAt": "2018-01-14T15:03:01+00:00",
              "score": 10
          },
          {
              "id": "4da7ed1b-4def-42ef-bd56-5b62b0a5ed05",
              "text": "Average",
              "createdAt": "2019-09-14T15:03:01+00:00",
              "score": 5
          },
          {
              "id": "590a960c-6fe7-456c-83be-71e19690637e",
              "text": "Very nice stay, I enjoyed it a lot.",
              "createdAt": "2019-09-14T15:03:01+00:00",
              "score": 9
          },
          {
              "id": "f2c5db4c-d497-4b7e-adbd-35fe538ad31a",
              "text": "Worst experience ever.",
              "createdAt": "2019-09-14T15:03:01+00:00",
              "score": 1
          }
      ]
    """

  Scenario: Getting the all hotels
    When I request "/api/v1/hotels" using HTTP GET
    Then the response code is 200
    Then the response body contains JSON:
    """
      [
          {
              "id": "1f451fb2-8ee5-4716-8ba2-dc308f6d842e",
              "name": "Hotel Alexanderplatz",
              "address": "Alexanderplatz 1, 10409, Berlin",
              "rooms": 150
          },
          {
              "id": "35d4e77c-562f-4bbc-a30e-ba5099021b3d",
              "name": "Hotel Alexanderplatz",
              "address": "Alexanderplatz 1, 10409, Berlin",
              "rooms": 150
          },
          {
              "id": "3c848009-8172-4373-9635-0c3153601ba6",
              "name": "Hotel Alexanderplatz",
              "address": "Alexanderplatz 1, 10409, Berlin",
              "rooms": 150
          },
          {
              "id": "b8e17d2e-3229-499a-a87d-8594198c46ad",
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
