<?php

use App\Models\Address;
use App\Services\ContactService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\RequestException;

uses(RefreshDatabase::class);

describe('Add Contact Test', function () {
    test('given valid contact data and the address has not been used before, then create a new contact with address', function () {
        // Arrange
        $contactData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '123456789',
            'postal_code' => '79756082',
        ];

        $service = new ContactService();
        
        // Act
        $service->create($contactData);

        // Assert
        $this->assertDatabaseHas('contacts', [
            'email' => 'john.doe@example.com',
            'name' => 'John Doe',
            'phone_number' => '123456789',
            'postal_code' => '79756082',
        ]);

        $this->assertDatabaseHas('addresses', [
            'postal_code' => '79756082',
            'city' => 'Nova Andradina',
            'state' => 'Mato Grosso do Sul',
            'country' => 'Brasil',
            'neighborhood' => 'Mambaré',
        ]);
    });

    test('given valid contact data and the address has been used before, then create a new contact without creating a new address', function () {
        // Arrange
        $existingAddress = [
            'postal_code' => '79756082',
            'street' => 'Rua Teste',
            'city' => 'Nova Andradina',
            'state' => 'Mato Grosso do Sul',
            'country' => 'Brasil',
            'neighborhood' => 'Mambaré',
            'unit' => '',
            'ibge_code' => '5006200',
            'gia_code' => '',
            'region' => 'Centro-Oeste',
            'area_code' => '67',
            'siafi_code' => '9123',
            'state_abbreviation' => 'MS',
            'complement' => '',
        ];

        Address::create($existingAddress);

        $contactData = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'phone_number' => '987654321',
            'postal_code' => '79756082',
        ];

        $service = new ContactService();

        // Act
        $service->create($contactData);

        // Assert
        $this->assertDatabaseHas('contacts', [
            'email' => 'jane.doe@example.com',
            'name' => 'Jane Doe',
            'phone_number' => '987654321',
            'postal_code' => '79756082',
        ]);

        $this->assertDatabaseHas('addresses', [
            'postal_code' => '79756082',
            'city' => 'Nova Andradina',
            'state' => 'Mato Grosso do Sul',
            'country' => 'Brasil',
            'neighborhood' => 'Mambaré',
        ]);
        $this->assertCount(1, Address::where('postal_code', '79756082')->get());
    });

    test('given invalid postal code, then contact creation fails', function () {
        // Arrange
        $contactData = [
            'name' => 'Invalid Contact',
            'email' => 'invalid.contact@example.com',
            'phone_number' => '000000000',
            'postal_code' => '0000000',
        ];

        $service = new ContactService();

        // Act
        $service->create($contactData);
       
        // Assert
        $this->assertDatabaseMissing('contacts', [
            'email' => 'invalid.contact@example.com',
            'name' => 'Invalid Contact',
            'phone_number' => '000000000',
            'postal_code' => '0000000',
        ]);
    })->throws(RequestException::class); 
});
