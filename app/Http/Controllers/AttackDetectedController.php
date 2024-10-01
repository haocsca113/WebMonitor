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

                // $this->sendAlert($website->url, 'SQL Injection');
                \Log::info('SQL Injection attack detected on ' . $website->url);
            }
            else {
                AttackDetected::create([
                    // 'user_id' => Auth::user()->id,
                    'user_id' => Auth::user() ? Auth::user()->id : 1,
                    'website_id' => $website->id,
                    'attack_type' => 'No Attack SQL Injection',
                    'detected_at' => now(),
                    'details' => 'Everything is OK',
                ]);
                \Log::info('No attack detected on ' . $website->url);
            }

            // Kiểm tra thêm các loại tấn công khác (ví dụ: brute force, XSS, v.v.)
            $this->detectBruteForceAttack($website);

        } catch (\Exception $e) {
            \Log::error('Error accessing website: ' . $website->url);
        }
    }

    public function detectBruteForceAttack($website) {
        \Log::info('Checking for brute force attacks on ' . $website->url);
    
        $loginUrl = $website->url . '/login'; // Đường dẫn tới form login của website
        $usernames = ['admin', 'testuser', 'root'];
        $passwords = ['wrongpassword1', 'wrongpassword2', 'wrongpassword3'];
    
        $failedAttempts = 0;
    
        foreach ($usernames as $username) {
            foreach ($passwords as $password) {
                try {
                    $response = $client->post($loginUrl, [
                        'form_params' => [
                            'username' => $username,
                            'password' => $password
                        ]
                    ]);
    
                    $loginContent = $response->getBody()->getContents();
    
                    if (strpos($loginContent, 'Invalid username or password') !== false) {
                        $failedAttempts++;
                    }
    
                    // Nếu số lần thử không thành công vượt quá ngưỡng cho phép
                    if ($failedAttempts >= 5) { // Ví dụ: 5 lần thử liên tiếp thất bại
                        AttackDetected::create([
                            'user_id' => Auth::user() ? Auth::user()->id : 1,
                            'website_id' => $website->id,
                            'attack_type' => 'Brute Force',
                            'detected_at' => now(),
                            'details' => 'Multiple failed login attempts detected.',
                        ]);
    
                        \Log::info('Brute force attack detected on ' . $website->url);
                        return; // Phát hiện brute force, ngừng kiểm tra
                    }
                } catch (\Exception $e) {
                    \Log::error('Error accessing login page of website: ' . $website->url);
                }
            }
        }
    
        \Log::info('No brute force attack detected on ' . $website->url);
    }



    public function sendAlert($url, $attackType)
    {
        $message = "Attack detected: {$attackType} on {$url}.";
        Mail::raw($message, function ($msg) {
            $msg->to('haocsca113@gmail.com')->subject('Website Attack Detected');
        });
    }
}
