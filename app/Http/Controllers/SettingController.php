<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use App\GeneralSetting;

use File;

use Spatie\Permission\Models\Role;

use App\User;

class SettingController extends Controller
{
    
    //Return general settings page
    public function getGeneralSettings()
    {
    	
    	$companyData = array(
    		'appName' => GeneralSetting::where('key', 'app.name')->firstOrFail()->value,
    		'appDispalyName' => GeneralSetting::where('key', 'app.name')->firstOrFail()->display_name,

    		'appLogo' => GeneralSetting::where('key', 'app.logo')->firstOrFail()->value,

    		'appTitle' => GeneralSetting::where('key', 'app.title')->firstOrFail()->value,
    		'titleDisplayName' => GeneralSetting::where('key', 'app.title')->firstOrFail()->display_name,

    		'appEmail' => GeneralSetting::where('key', 'app.email')->firstOrFail()->value,
    		'emailDispalyName' => GeneralSetting::where('key', 'app.email')->firstOrFail()->display_name,

    		'appPhone' => GeneralSetting::where('key', 'app.phone')->firstOrFail()->value,
    		'phoneDispalyName' => GeneralSetting::where('key', 'app.phone')->firstOrFail()->display_name,

    		'appAddress' => GeneralSetting::where('key', 'app.address')->firstOrFail()->value,
    		'addressDispalyName' => GeneralSetting::where('key', 'app.address')->firstOrFail()->display_name,

    		'appTimeZone' => GeneralSetting::where('key', 'app.timezone')->firstOrFail()->value,
    		'timeZoneDispalyName' => GeneralSetting::where('key', 'app.timezone')->firstOrFail()->display_name,

    		'appContactLink' => GeneralSetting::where('key', 'app.contactlink')->firstOrFail()->value,
    		'contactLinkDispalyName' => GeneralSetting::where('key', 'app.contactlink')->firstOrFail()->display_name,

    	);

    	$companyData = (object) $companyData;

    	return view('settings.general', compact('companyData'));
    }


    //Update general settings page
    public function updateGeneralSettings(Request $request)
    {
    	$request->validate([

            'companyName' => 'required|string|max:255',
            'companyLogo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'companyTitle' => 'string|max:255',
            'comapnyEmail' => 'required|max:255|string|email',
            'companyPhone' => 'required|regex:/(01)[0-9]{9}/|max:15',
            'companyAddress' => '|string|max:255',
            'contactLink' => 'required|string|max:255',

        ]);




    	GeneralSetting::where('key', 'app.name')->firstOrFail()->update(['value' => $request->companyName]);
    	
    	if(!empty($request->companyLogo))
    	{
    		
    		//upload the new logo
    		$companyLogo = time().'.'.$request->companyLogo->getClientOriginalExtension();
	        $request->companyLogo->move(public_path('uploads/company_logo'), $companyLogo);

	        //remove the current logo
	        $currentLogo = GeneralSetting::where('key', 'app.logo')->firstOrFail()->value;
			File::delete(public_path('uploads/company_logo/').$currentLogo);

			//update the logo name on database
	        GeneralSetting::where('key', 'app.logo')->firstOrFail()->update(['value' => $companyLogo]);
    	}
    	
    	GeneralSetting::where('key', 'app.title')->firstOrFail()->update(['value' => $request->companyTitle]);
    	GeneralSetting::where('key', 'app.email')->firstOrFail()->update(['value' => $request->comapnyEmail]);
    	GeneralSetting::where('key', 'app.phone')->firstOrFail()->update(['value' => $request->companyPhone]);
    	GeneralSetting::where('key', 'app.address')->firstOrFail()->update(['value' => $request->companyAddress]);
    	GeneralSetting::where('key', 'app.timezone')->firstOrFail()->update(['value' => $request->timeZone]);
    	GeneralSetting::where('key', 'app.contactlink')->firstOrFail()->update(['value' => $request->contactLink]);

    	return redirect()->back()->with('success', 'General settings updated');

	       

    }

   

}
