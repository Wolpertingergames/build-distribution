<?php

namespace App\Http\Controllers;

use Response;
use App\Helpers\AwsLinkService;
use App\User;
use App\Project;
use App\Build;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

class BuildController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function show(Guard $auth, $projectId, $buildId)
	{
		$project = Project::findByIdOrName($projectId);
		$builds = $project->builds()->where('id', '=', $buildId)->get();
    
		return view('partials.builds', compact('builds'));
	}
	
	public function generateIphonePlist($buildId)
	{
		$build = Build::find($buildId);
		
		$data = [
			'url' => AWSLinkService::getPresignedLink($build->installFolder, $build->installFileName),
			'bundleIdentifier' => $build->bundleIdentifier,
			'bundleVersion' => $build->iphoneBundleVersion,
			'iphoneTitle' => $build->iphoneTitle
		];
		
		$contents = view('assets.plist', ['data' => $data]);
		$response = Response::make($contents, 200);
		$response->header('Content-Type', 'text/plain');
		return $response;	
	}
}
