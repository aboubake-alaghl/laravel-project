<?php

use App\Services\OrderService;

beforeEach(function () {
    $orderServiceMock = Mockery::mock(OrderService::class);
});

afterEach(function () {
    Mockery::close();
});

it('', function () {
    //
});
