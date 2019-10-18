<?php

namespace App\Http\Controllers;

use App\Dinamicos;
use Illuminate\Http\Request;

class DinamicosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $dinamicos = Dinamicos::orderBy('id', 'DESC')->paginate(4);
        }
        else{
            $dinamicos = Dinamicos::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'DESC')->paginate(4);
        }
        return [
            'pagination' => [
                'total'        => $dinamicos->total(),
                'current_page' => $dinamicos->currentPage(),
                'per_page'     => $dinamicos->perPage(),
                'last_page'    => $dinamicos->lastPage(),
                'from'         => $dinamicos->firstItem(),
                'to'           => $dinamicos->lastItem(),
            ],
            'dinamicos' => $dinamicos
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title="Dinamicos";
        return view('dinamicos.crear', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $datos = $request->data;

        foreach($datos as $ep=>$d)
        {
            $din=new Dinamicos();
            $din->nom=$d['nom'];
            $din->ap=$d['ap'];
            $din->save();
        }


        // $dinamico = new Dinamicos();
        // $dinamico->nom = $request->nom;
        // $dinamico->ap = $request->ap;
        // $dinamico->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dinamicos  $dinamicos
     * @return \Illuminate\Http\Response
     */
    public function show(Dinamicos $dinamicos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dinamicos  $dinamicos
     * @return \Illuminate\Http\Response
     */
    public function edit(Dinamicos $dinamicos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dinamicos  $dinamicos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dinamicos $dinamicos)
    {
        if (!$request->ajax()) return redirect('/');
        $clientes = Dinamicos::findOrFail($request->id);
        $clientes->nom = $request->nom;
        $clientes->ap = $request->ap;
        $clientes->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dinamicos  $dinamicos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dinamicos $dinamicos)
    {
        //
    }
}
