<?php

use App\Models\Address;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

describe('List Contacts Test', function () {

  beforeEach(function() {
    $addressData = [
      [
        'postal_code' => '12345678',
        'street' => '123 Main St',
        'complement' => 'Apt 1',
        'neighborhood' => 'Downtown',
        'city' => 'Cityville',
        'unit' => 'Unit 1',
        'country' => 'Brasil',
        'state_abbreviation' => 'SP',
        'state' => 'São Paulo',
        'ibge_code' => '1234567',
        'gia_code' => '',
        'region' => '',
        'area_code' => '',
        'siafi_code' => '',
      ],
      [
        'postal_code' => '87654321',
        'street' => '456 Elm St',
        'complement' => 'Apt 2',
        'neighborhood' => 'Uptown',
        'city' => 'Townsville',
        'unit' => 'Unit 2',
        'country' => 'Brasil',
        'state_abbreviation' => 'RJ',
        'state' => 'Rio de Janeiro',
        'ibge_code' => '7654321',
        'gia_code' => '',
        'region' => '',
        'area_code' => '',
        'siafi_code' => '',
      ],
      [
        'postal_code' => '55555555',
        'street' => '789 Oak St',
        'complement' => 'Apt 3',
        'neighborhood' => 'Midtown',
        'city' => 'Metrocity',
        'unit' => 'Unit 3',
        'country' => 'Brasil',
        'state_abbreviation' => 'MG',
        'state' => 'Minas Gerais',
        'ibge_code' => '5555555',
        'gia_code' => '',
        'region' => '',
        'area_code' => '',
        'siafi_code' => '',
      ],
      [
        'postal_code' => '44444444',
        'street' => '321 Pine St',
        'complement' => 'Apt 4',
        'neighborhood' => 'Suburbia',
        'city' => 'Suburbia City',
        'unit' => 'Unit 4',
        'country' => 'Brasil',
        'state_abbreviation' => 'BA',
        'state' => 'Bahia',
        'ibge_code' => '4444444',
        'gia_code' => '',
        'region' => '',
        'area_code' => '',
        'siafi_code' => '',
      ],
      [
        'postal_code' => '33333333',
        'street' => '654 Maple St',
        'complement' => 'Apt 5',
        'neighborhood' => 'Countryside',
        'city' => 'Countrytown',
        'unit' => 'Unit 5',
        'country' => 'Brasil',
        'state_abbreviation' => 'PR',
        'state' => 'Paraná',
        'ibge_code' => '3333333',
        'gia_code' => '',
        'region' => '',
        'area_code' => '',
        'siafi_code' => '',
      ],
    ];

    foreach ($addressData as $data) {
        Address::create($data);
    }

    $contactData = [
      [
        'name' => 'Jane Doe',
        'email' => 'jane.doe@example.com',
        'phone_number' => '123456789',
        'postal_code' => '12345678',
      ],
      [
        'name' => 'John Smith',
        'email' => 'john.smith@example.com',
        'phone_number' => '987654321',
        'postal_code' => '87654321',
      ],
      [
        'name' => 'Alice Johnson',
        'email' => 'alice.johnson@example.com',
        'phone_number' => '555555555',
        'postal_code' => '55555555',
      ],
      [
        'name' => 'Bob Brown',
        'email' => 'bob.brown@example.com',
        'phone_number' => '444444444',
        'postal_code' => '44444444',
      ],
      [
        'name' => 'Charlie Davis',
        'email' => 'charlie.davis@example.com',
        'phone_number' => '333333333',
        'postal_code' => '33333333',
      ],
    ];

    foreach ($contactData as $data) {
        Contact::create($data);
    }
  });

  test('given no filter was applied, then return paginated contacts', function () {
      // Arrange
      $service = new ContactService();

      // Act
      $result = $service->findAll();

      // Assert
      expect($result->count())->toBe(5);
  });

  test('given a filter by name, then return contacts matching the name', function () {
    // Arrange
    $service = new ContactService();

    // Act
    $result = $service->findAll(['name' => 'Jane Doe']);

    // Assert
    expect($result->count())->toBe(1);
    expect($result->first()->name)->toBe('Jane Doe');
  });

  test('given a filter by email, then return contacts matching the email', function () {
    // Arrange
    $service = new ContactService();

    // Act
    $result = $service->findAll(['email' => 'john.smith@example.com']);

    // Assert
    expect($result->count())->toBe(1);
    expect($result->first()->email)->toBe('john.smith@example.com');
  });
});
