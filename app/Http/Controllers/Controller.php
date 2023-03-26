<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $data = [];
	protected $uploadsFolder = 'uploads/';

	protected $rajaOngkirApiKey = null;
	protected $rajaOngkirBaseUrl = null;
	protected $rajaOngkirOrigin = null;
	protected $couriers = [
		'jne' => 'JNE',
		'pos' => 'POS Indonesia',
		'tiki' => 'Titipan Kilat'
	];

    protected $provinces = [];

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->rajaOngkirApiKey = config('ongkir.api_key');
		$this->rajaOngkirBaseUrl = config('ongkir.base_url');
		$this->rajaOngkirOrigin = config('ongkir.origin');
	}
    /**
	 * Raja Ongkir Request (Shipping Cost Calculation)
	 *
	 * @param string $resource resource url
	 * @param array  $params   parameters
	 * @param string $method   request method
	 *
	 * @return json
	 */
	protected function rajaOngkirRequest($resource, $params = [], $method = 'GET')
	{
		$client = new \GuzzleHttp\Client();

		$headers = ['key' => $this->rajaOngkirApiKey];
		$requestParams = [
			'headers' => $headers,
		];
		
		$url =  $this->rajaOngkirBaseUrl . $resource;
		if ($params && $method == 'POST') {
			$requestParams['form_params'] = $params;
		} else if ($params && $method == 'GET') {
			$query = is_array($params) ? '?'.http_build_query($params) : '';
			$url = $this->rajaOngkirBaseUrl . $resource . $query;
		}

		$response = $client->request($method, $url, $requestParams);

		return json_decode($response->getBody(), true);
    }
    
    /**
	 * Get provinces
	 *
	 * @return array
	 */
	protected function getProvinces()
	{
		$provinceFile = 'provinces.txt';
		$provinceFilePath = $this->uploadsFolder. 'files/' . $provinceFile;

		$isExistProvinceJson = \Storage::disk('local')->exists($provinceFilePath);

		if (!$isExistProvinceJson) {
			$response = $this->rajaOngkirRequest('province');
			\Storage::disk('local')->put($provinceFilePath, serialize($response['rajaongkir']['results']));
		}

		$province = unserialize(\Storage::get($provinceFilePath));

		$provinces = [];
		if (!empty($province)) {
			foreach ($province as $province) {
				$provinces[$province['province_id']] = strtoupper($province['province']);
			}
		}
		
        return $provinces;
	}
	
	/**
	 * Get cities by province ID
	 *
	 * @param int $provinceId province id
	 *
	 * @return array
	 */
	protected function getCities($provinceId)
	{
		$cityFile = 'cities_at_'. $provinceId .'.txt';
		$cityFilePath = $this->uploadsFolder. 'files/' .$cityFile;

		$isExistCitiesJson = \Storage::disk('local')->exists($cityFilePath);

		if (!$isExistCitiesJson) {
			$response = $this->rajaOngkirRequest('city', ['province' => $provinceId]);
			\Storage::disk('local')->put($cityFilePath, serialize($response['rajaongkir']['results']));
		}

		$cityList = unserialize(\Storage::get($cityFilePath));
		
		$cities = [];
		if (!empty($cityList)) {
			foreach ($cityList as $city) {
				$cities[$city['city_id']] = strtoupper($city['type'].' '.$city['city_name']);
			}
        }
		
		return $cities;
	}

	protected function getShippingCost($destination, $weight)
	{
		$params = [
			'origin' => $this->rajaOngkirOrigin,
			'destination' => $destination,
			'weight' => $weight,
		];

		$results = [];
		foreach ($this->couriers as $code => $courier) {
			$params['courier'] = $code;
			
            $response = $this->rajaOngkirRequest('cost', $params, 'POST');
			
			if (!empty($response['rajaongkir']['results'])) {
				foreach ($response['rajaongkir']['results'] as $cost) {
					if (!empty($cost['costs'])) {
						foreach ($cost['costs'] as $costDetail) {
							$serviceName = strtoupper($cost['code']) .' - '. $costDetail['service'];
							$costAmount = $costDetail['cost'][0]['value'];
							$etd = $costDetail['cost'][0]['etd'];

							$result = [
								'service' => $serviceName,
								'cost' => $costAmount,
								'etd' => $etd,
								'courier' => $code,
							];

							$results[] = $result;
						}
					}
				}
			}
		}

		$response = [
			'origin' => $params['origin'],
			'destination' => $destination,
			'weight' => $weight,
			'results' => $results,
		];
		
		return $response;
	}

	protected function initPaymentGateway()
	{
		// Set your Merchant Server Key
		\Midtrans\Config::$serverKey = config('midtrans.serverKey');
		// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
		\Midtrans\Config::$isProduction = false;
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = true;
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = true;
	}
}
