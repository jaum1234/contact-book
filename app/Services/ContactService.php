<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Contact;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactService {

  /**
   * Create a new contact with address.
   * 
   * @param array $data
   * @return void
   * 
   * @throws RequestException
   */
  public function create(array $data) {
    if (!Address::where('postal_code', $data['postal_code'])->first()) {
      Log::info('Fetching address information from ViaCEP', ['postal_code' => $data['postal_code']]);
  
      $addressInfo = Http::get(config('services.viacep.base_url') . $data['postal_code'] . '/json/')
        ->throw()  
        ->json();
  
      Log::info('Address information retrieved successfully', ['address' => $addressInfo]);
  
      $address = new Address();
  
      $address->postal_code = str_replace('-', '', $addressInfo['cep']);
      $address->street = $addressInfo['logradouro'];
      $address->complement = $addressInfo['complemento'];
      $address->neighborhood = $addressInfo['bairro'];
      $address->city = $addressInfo['localidade'];
      $address->unit = $addressInfo['unidade'];
      $address->country = 'Brasil';
      $address->state_abbreviation = $addressInfo['uf'];
      $address->state = $addressInfo['estado'];
      $address->ibge_code = $addressInfo['ibge'];
      $address->gia_code = $addressInfo['gia'];
      $address->region = $addressInfo['regiao'];
      $address->area_code = $addressInfo['ddd'];
      $address->siafi_code = $addressInfo['siafi'];
      $address->save();
  
      Log::info('Address saved successfully', ['postal_code' => $address->postal_code]);
    }

    $contact = new Contact();
    $contact->name = $data['name'];
    $contact->email = $data['email'];
    $contact->phone_number = $data['phone_number'];
    $contact->postal_code = $data['postal_code'];
    $contact->save();

    Log::info('Contact saved successfully', ['email' => $contact->email]);
  }
}