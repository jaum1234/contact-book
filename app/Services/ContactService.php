<?php

use App\Models\Address;
use App\Models\Contact;
use Illuminate\Support\Facades\Http;

class ContactService {
  public function create(array $data) {
    $addressInfo = Http::get(config('services.viacep.base_url') . $data['postal_code'] . '/json/')
        ->throw()
        ->json();

    $address = new Address();

    $address->postal_code = $addressInfo['cep'];
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

    $contact = new Contact();
    $contact->name = $data['name'];
    $contact->email = $data['email'];
    $contact->phone_number = $data['phone_number'];
    $contact->postal_code = $data['postal_code'];
    $contact->save();
  }
}