<?php

namespace App\Http\Controllers;
use App\Models\UptimeCheck;
use GuzzleHttp\Client;

use Illuminate\Http\Request;

class UptimeCheckController extends Controller
{
    public function uptime_check() {
        $uptime_checks = UptimeCheck::orderBy('created_at', 'desc')->get();
        return view('admincp.uptime_check.index', compact('uptime_checks'));
    }

    public function check_url() {
        return view('admincp.uptime_check.check_url');
    }

    public function check_up_time(Request $request)
    {
        $url = $request->input('url');
        $client = new Client();
        try {
            $start = microtime(true);
            $response = $client->request('GET', $url);
            $end = microtime(true);

            $status = $response->getStatusCode() === 200;
            $responseTime = ($end - $start) * 1000;

            UptimeCheck::create([
                'url' => $url,
                'status' => $status,
                'response_time' => $responseTime,
            ]);
        } catch (\Exception $e) {
            UptimeCheck::create([
                'url' => $url,
                'status' => false,
                'response_time' => 0,
            ]);
        }

        return redirect()->route('uptime-check');
    }
}
