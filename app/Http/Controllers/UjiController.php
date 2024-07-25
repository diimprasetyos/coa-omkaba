<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UjiController extends Controller
{
    private $data_acuan;

    public function __construct()
    {
        // Baca file JSON dan simpan sebagai array
        $json = File::get(public_path('data/datauji.json'));
        $this->data_acuan = json_decode($json, true);
    }

    public function showInputForm()
    {
        // Ambil nama perusahaan dari data JSON
        $companies = array_unique(array_column($this->data_acuan, 'Nama Perusahaan'));
        return view('input_form', compact('companies'));
    }

    public function getProductData(Request $request)
    {
        $filtered_data = array_filter($this->data_acuan, function ($item) use ($request) {
            if ($request->has('nama_produk')) {
                return isset($item['Nama Perusahaan']) && $item['Nama Perusahaan'] === $request->nama_perusahaan &&
                    isset($item['Nama Produk']) && $item['Nama Produk'] === $request->nama_produk;
            } else {
                return isset($item['Nama Perusahaan']) && $item['Nama Perusahaan'] === $request->nama_perusahaan;
            }
        });

        if ($request->has('nama_produk')) {
            $data = count($filtered_data) > 0 ? array_shift($filtered_data) : [];
        } else {
            $data = array_values($filtered_data);
        }

        return response()->json($data);
    }


    public function validateData(Request $request)
    {
        // Filter data berdasarkan nama perusahaan dan produk
        $filtered_data = array_filter($this->data_acuan, function ($item) use ($request) {
            return isset($item['Nama Perusahaan']) && $item['Nama Perusahaan'] === $request->nama_perusahaan &&
                isset($item['Nama Produk']) && $item['Nama Produk'] === $request->nama_produk;
        });

        if (count($filtered_data) > 0) {
            $data_acuan = array_shift($filtered_data);
        } else {
            return back()->withErrors(['msg' => 'Data acuan tidak ditemukan.']);
        }

        $is_passed = true;
        $messages = [];

        // validasi logam
        $logam_fields = ['As', 'Pb', 'Hg', 'Cd', 'Sn'];
        foreach ($logam_fields as $field) {
            $input_value = $request->input('logam_' . strtolower($field));
            $acuan_value = $data_acuan['Logam'][$field] ?? null;

            if ($input_value !== null && $acuan_value !== null) {
                if ($input_value > $acuan_value) {
                    $is_passed = false;
                    $messages[] = "Kadar Logam $field melebihi ambang batas acuan.";
                }
            }
        }

        // validasi mikrobiologi
        if (isset($data_acuan['Mikrobiologi'])) {
            foreach ($data_acuan['Mikrobiologi'] as $key => $value) {
                $input_value = $request->input('mikrobiologi_' . strtolower(str_replace(' ', '_', $key)));

                // convertinput ke numeric
                $acuan_numeric = floatval($value);
                $input_numeric = floatval($input_value);

                if ($input_value !== null && $acuan_numeric !== null) {
                    if ($input_numeric > $acuan_numeric) {
                        $is_passed = false;
                        $messages[] = "$key melebihi ambang batas acuan.";
                    }
                }
            }
        }


        if ($is_passed) {
            $messages[] = 'Lolos hasil uji.';
        } else {
            $messages[] = 'Tidak lolos hasil uji.';
        }

        $currentDate = date('Y-m-d');

        return view('result', compact('is_passed', 'messages', 'data_acuan', 'request','currentDate'));
    }
}
