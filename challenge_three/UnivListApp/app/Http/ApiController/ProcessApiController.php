<?php

namespace App\Http\ApiController;

use App\Http\Controllers\Controller;
use App\Models\University;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        $arrayKey = array("United States", "Canada");

        DB::beginTransaction();

        foreach ($arrayKey as $key){
            if(!University::where('country', rawurlencode($key))->first()){
                try {
                        $response = Http::get('http://universities.hipolabs.com/search?country='.rawurlencode($key));
                        $universities = json_decode($response->body());
                        foreach ($universities as $univ){
                            $university = University::create([
                                'state-province' => $univ->{'state-province'},
                                'alpha_two_code' => $univ->{'alpha_two_code'},
                                'country' => $univ->country,
                                'name' => $univ->name
                            ]);

                            if(!empty($univ->domains)){
                                foreach($univ->domains as $domain){
                                    $university->domains()->create([
                                        'domain' => $domain
                                    ]);
                                }
                            }

                            if(!empty($univ->web_pages)){
                                foreach($univ->web_pages as $pages) {
                                    $university->webPages()->create([
                                        'url' => $pages
                                    ]);
                                }
                            }
                            DB::commit();
                        }
                }catch (ConnectException $e){
                    DB::rollBack();
                    Log::error($e->getMessage());
                }
            }
        }
        return response()->redirectTo('/')->with('status', 'API Successfully Run!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
