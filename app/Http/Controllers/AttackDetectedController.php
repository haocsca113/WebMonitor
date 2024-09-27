<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\AttackDetected;
use App\Models\Website;
use App\Jobs\AttackDetectedJob;
use GuzzleHttp\Client;

class AttackDetectedController extends Controller
{
    public function attack_detected_home() {
        $attacks_detected = AttackDetected::where('user_id', '=', Auth::user()->id)->get();
        return view('admincp.attack_detected.home_attack_detected', compact('attacks_detected'));
    }

    public function check_url_attack_detected() {
        return view('admincp.attack_detected.check_url');
    }

    public function attack_detected(Website $website) {
        // if (!Auth::check()) {
        //     \Log::error('No authenticated user found!');
        //     return;
        // }

        \Log::info('Monitoring website: ' . $website->url);
     
        try {
            \Log::info('Monitoring website: ' . $website->url);
            $client = new Client();
            $response = $client->get($website->url, [
                'query' => ['id' => "' OR 1=1 --"]
            ]);
            $content = $response->getBody()->getContents();

            if (strpos($content, 'error in your SQL syntax') !== false) {
                AttackDetected::create([
                    // 'user_id' => Auth::user()->id,
                    'user_id' => Auth::user() ? Auth::user()->id : 1,
                    'website_id' => $website->id,
                    'attack_type' => 'SQL Injection',
                    'detected_at' => now(),
                    'details' => 'SQL syntax error found in response.',
                ]);

                // Gửi cảnh báo qua email hoặc hiển thị trên dashboard
                // $this->sendAlert($website->url, 'SQL Injection');
                \Log::info('SQL Injection attack detected on ' . $website->url);
            }
            else {
                AttackDetected::create([
                    // 'user_id' => Auth::user()->id,
                    'user_id' => Auth::user() ? Auth::user()->id : 1,
                    'website_id' => $website->id,
                    'attack_type' => 'No Attack',
                    'detected_at' => now(),
                    'details' => 'Everything is OK',
                ]);
                \Log::info('No attack detected on ' . $website->url);
            }

            // Kiểm tra thêm các loại tấn công khác (ví dụ: brute force, XSS, v.v.)
            // ...

        } catch (\Exception $e) {
            \Log::error('Error accessing website: ' . $website->url);
        }
    }

    public function sendAlert($url, $attackType)
    {
        $message = "Attack detected: {$attackType} on {$url}.";
        Mail::raw($message, function ($msg) {
            $msg->to('haocsca113@gmail.com')->subject('Website Attack Detected');
        });
    }
}
