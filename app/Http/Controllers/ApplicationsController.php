<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Exceptions\HandshakeFailedException;

class ApplicationsController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('applications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$formData = $request->except('_token');
		$validator = \Validator::make($formData, [
			'home' => 'required|url',
			'name' => 'required|string',
			'callback' => 'required|url'
		], [
			'required' => 'The :attribute is required',
			'url' => 'The :attribute must be a valid url'
		]);

		if ($validator->fails()) {
    		return redirect()->back()
                        ->withInput($request->input())
                        ->withErrors($validator);
		}

		$application = new Application($formData);

		// Add handshake

		$user = \Auth::user();
		try {
			$user->applications()->save($application);
		} catch (HandshakeFailedException $e) {
    		return redirect()->back()
                        ->withInput($request->input())
						->withError('Application failed to handshake');

		}

		return redirect('home')->withStatus('Application saved!');
	}

    /**
     * Display the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response

    public function show(Application $application)
    {
    }
	*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
    public function edit(Application $application)
    {
        //
    }
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
}
