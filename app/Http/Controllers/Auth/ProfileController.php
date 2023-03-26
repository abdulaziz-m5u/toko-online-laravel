<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
	{
		$user = auth()->user();
		
        $provinces = $this->getProvinces();
        $cities = isset($user->province_id) ? $this->getCities($user->province_id) : [];
        
		return view('frontend.auth.profile', compact('user','provinces','cities'));
    }
    
    public function update(Request $request)
	{
		$params = $request->except('_token');

		$user = auth()->user();

		if ($user->update($params)) {
			return redirect('profile');
		}
	}
}
