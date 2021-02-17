<?php

namespace App\Http\Controllers;

use App\Imports\LgaImport;
use App\Models\Lga;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LgaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lgas = Lga::query()
            ->select(['state', 'lga'])
            ->groupBy(['state', 'lga'])
            ->get()
            ->mapToGroups(function ($item, $key) {
                return [$item['state'] => $item['lga']];
            });

        return response()->json(["status" => "success", "data" => $lgas]);

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

    public function importfile(Request $request)
    {
        Excel::import(new LgaImport, request()->file('file'));
        return response()->json(['message' => "File uploaded successfully"]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
