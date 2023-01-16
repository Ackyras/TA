<?php

namespace Database\Seeders\Trait;

use App\Models\District;
use App\Models\Village;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

trait FetchPublicApi
{
    protected $url = 'https://dev.farizdotid.com/api/daerahindonesia/';
    protected $client;
    protected $city_id = 1206;
    protected $province_id = 12;

    public function __construct()
    {
        $this->client = new Client(
            [
                'base_url'  =>  $this->url,
            ]
        );
    }

    public function fetch($target, $id)
    {
        if ($target == 'dsitrict') {
        }
    }

    public function prepareQuery(array $queries)
    {
        $query = '?';
        foreach ($queries as $key => $value) {
            $query .= $key . '=' . $value . '&';
        }
        return $query;
    }

    public function fetchDistrict($city_id = null, $province_id = null)
    {
        if ($province_id == null) {
            $province_id = $this->province_id;
        }
        if ($city_id == null) {
            $city_id = $this->city_id;
        }

        $query = $this->prepareQuery(
            [
                'id_kota'       =>  $city_id,
                'id_provinsi'   =>  $province_id,
            ]
        );

        $request = $this->client->request('GET', $this->url . 'kecamatan' . $query);

        $response = $request ? $request->getBody()->getContents() : null;
        $status = $request ? $request->getStatusCode() : 500;

        if ($response && $status === 200 && $response !== 'null') {
            $json = json_decode($response, true);
            $districts = [];
            foreach ($json['kecamatan'] as $district) {
                $district['villages'] = $this->fetchVillage($district['id']);
                array_push(
                    $districts,
                    $district
                );
                $newDistrict = District::create(
                    [
                        'name'  =>  $district['nama']
                    ]
                );
                $villages = $newDistrict->villages()->createMany(
                    $district['villages']
                );
            }
        }
    }

    public function fetchVillage(int $district_id, $city_id = null, $province_id = null)
    {
        // dd($district);
        if ($province_id == null) {
            $province_id = $this->province_id;
        }
        if ($city_id == null) {
            $city_id = $this->city_id;
        }

        $query = $this->prepareQuery(
            [
                'id_kecamatan'  =>  $district_id
            ]
        );

        $request = $this->client->request('GET', $this->url . 'kelurahan' . $query);

        $response = $request ? $request->getBody()->getContents() : null;
        $status = $request ? $request->getStatusCode() : 500;

        if ($response && $status === 200 && $response !== 'null') {
            $json = json_decode($response, true);
            $villages = [];
            foreach ($json['kelurahan'] as $village) {
                $villages[] = ['name' => $village['nama']];
            }
            return $villages;
        }
        return null;
    }
}
