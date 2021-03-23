<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;
class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $repuest)
    {
        $this->validate($repuest, Profile::$rules);
        $profile = new Profile;
        $form = $repuest->all();
        
        if(isset($form['image'])) {
            $path = $repuest->file('image')->store('public/image');
            $profile->image_path = basename($path);
        } else {
            $profile->image_path = null;
        }
    
        unset($form['_token']);
        
        unset($form['image']);
        
        $profile->fill($form);
        $profile->save();
                
        return redirect('admin/profile/create');
    }

    public function edit(Request $repuest)
    {
        
        $profile = Profile::find($repuest->id);
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update(Request $repuest)
    {
        
        $this->validate($repuest, Profile::$rules);
        
        $profile = Profile::find($repuest->id);
        
        $profile_form = $repuest->all();
        unset($profile_form['_token']);
        
        $profile->fill($profile_form)->save();
        
        return redirect('admin/profile/edit?id=1');
    }
}
