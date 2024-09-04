<?php


it('returns a 201 response', function () {

    $data = [
        "first_name" => "Fname",
        "last_name" => "Lname",
        "email" => "username@example.com",
        "phone" => "5555666677777",
        "password" => "34rtwdfw34tfsfg3A",
        "gender" => 1,
        "delivery_status" => "AVAILABLE",
        "status" => "LATER"
    ];

    $response = $this->post('http://127.0.0.1:8000/api/v1/drivers/signup', $data);

    $response->assertStatus(201);
});


it('returns a 200 response', function () {

    $data = [
        "identifier" => "55345553421",
        "password" => "34rtwdfw34tfsfg3A",
    ];

    $response = $this->post('http://127.0.0.1:8000/api/v1/drivers/login', $data);

    $response->assertStatus(401);
});
