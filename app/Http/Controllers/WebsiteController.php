<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Website;

class WebsiteController extends Controller
{
    public function website_home() {
        $websites = Website::where('user_id', '=', Auth::user()->id)->get();
        return view('admincp.website.website_home', compact('websites'));
    }

    public function add_url() {
        return view('admincp.website.add_url');
    }

    public function add_url_store(Request $request) {
        $data = $request->all();
        $website = new Website();
        $website->user_id = Auth::user()->id;
        $website->url = $data['url'];
        $website->save();

        return redirect()->route('website-home');
    }

    public function view_url($id) {
        $website = Website::where('user_id', '=', Auth::user()->id)->find($id);
        return view('admincp.website.view_url', compact('website'));
    }

    public function edit_url($id) {
        $website = Website::where('user_id', '=', Auth::user()->id)->find($id);
        return view('admincp.website.edit_url', compact('website'));
    }

    public function update_url(Request $request, $id) {
        $website = Website::where('user_id', '=', Auth::user()->id)->find($id);
        $data = $request->all();
        $website->update($data);

        return redirect()->route('website-home');
    }

    public function delete_url(Request $request, $id) {
        Website::destroy($id);
        return redirect()->route('website-home');
    }
}
