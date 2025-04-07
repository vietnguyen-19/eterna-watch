<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    protected $baseUrl = 'https://provinces.open-api.vn/api';

    public function getProvinces()
    {
        try {
            $response = Http::get($this->baseUrl . '/p/');
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể lấy danh sách tỉnh/thành phố'], 500);
        }
    }

    public function getDistricts($provinceCode)
    {
        try {
            $response = Http::get($this->baseUrl . '/p/' . $provinceCode, [
                'depth' => 2
            ]);
            return response()->json($response->json()['districts'] ?? []);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể lấy danh sách quận/huyện'], 500);
        }
    }

    public function getWards($districtCode)
    {
        try {
            $response = Http::get($this->baseUrl . '/d/' . $districtCode, [
                'depth' => 2
            ]);
            
            // Log response for debugging
            \Log::info('Wards API Response:', [
                'district_code' => $districtCode,
                'response' => $response->json()
            ]);
            
            $wards = $response->json()['wards'] ?? [];
            
            // Transform data to match expected format
            $transformedWards = collect($wards)->map(function($ward) {
                return [
                    'code' => $ward['code'],
                    'name' => $ward['name'],
                ];
            })->values()->all();
            
            return response()->json($transformedWards);
        } catch (\Exception $e) {
            \Log::error('Error in getWards:', [
                'message' => $e->getMessage(),
                'district_code' => $districtCode
            ]);
            return response()->json(['error' => 'Không thể lấy danh sách phường/xã'], 500);
        }
    }

    public function searchProvinces(Request $request)
    {
        try {
            $response = Http::get($this->baseUrl . '/p/search/', [
                'q' => $request->query('q')
            ]);
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể tìm kiếm tỉnh/thành phố'], 500);
        }
    }

    public function searchDistricts(Request $request)
    {
        try {
            $params = ['q' => $request->query('q')];
            if ($request->has('p')) {
                $params['p'] = $request->query('p');
            }
            
            $response = Http::get($this->baseUrl . '/d/search/', $params);
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể tìm kiếm quận/huyện'], 500);
        }
    }

    public function searchWards(Request $request)
    {
        try {
            $params = ['q' => $request->query('q')];
            if ($request->has('d')) {
                $params['d'] = $request->query('d');
            }
            if ($request->has('p')) {
                $params['p'] = $request->query('p');
            }
            
            $response = Http::get($this->baseUrl . '/w/search/', $params);
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể tìm kiếm phường/xã'], 500);
        }
    }
} 