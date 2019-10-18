<?php

namespace App\Http\Controllers;

use App\Clientes2;
use Illuminate\Http\Request;

class Clientes2Controller extends Controller
{

    public function buscar()
    {
        $clientes2 = Clientes2::with('cursos')->orderBy('id', 'DESC')->get();

        //dd($clientes2);
    }


    public function home()
    {
        $title="Clientes";
        return view('clientes2.index',compact('title'));
    }
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
            $clientes2 = Clientes2::with('cursos')->orderBy('id', 'DESC')->paginate(4);
        }
        else{
            $clientes2 = Clientes2::with('cursos')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'DESC')->paginate(4);
        }
        return [
            'pagination' => [
                'total'        => $clientes2->total(),
                'current_page' => $clientes2->currentPage(),
                'per_page'     => $clientes2->perPage(),
                'last_page'    => $clientes2->lastPage(),
                'from'         => $clientes2->firstItem(),
                'to'           => $clientes2->lastItem(),
            ],
            'clientes2' => $clientes2
        ];
    }

    public function selectCategoria(Request $request){
        if (!$request->ajax()) return redirect('/');
        $clientes = Clientes2::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['categorias' => $clientes];
    }

    public function listarPdf(){
        $clientes = Clientes::select('nombre','descripcion','condicion')->orderBy('nombre', 'asc')->get();
        $cont=Clientes::count();

        $pdf = \PDF::loadView('pdf.categoriaspdf',['categorias'=>$clientes,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('categorias.pdf');
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
        $clientes = new Clientes();
        $clientes->nom = $request->nom;
        $clientes->ap = $request->ap;
        $clientes->condicion = '1';



        //imagen
        //inicio registrar imagen
        $exploded = explode(',',$request->foto);
        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0],'jpeg')){

            $extension = 'jpg';

        } else{

            $extension = 'png';
        }

        $fileName= str_random().'.'.$extension;

        $path = public_path().'/img/clientes/'.$fileName;

        file_put_contents($path,$decoded);

        $clientes->foto = $fileName;

        //fin registrar imagen

        $clientes->save();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $clientes = Clientes::findOrFail($request->id);
        $clientes->nom = $request->nom;
        $clientes->ap = $request->ap;
        $clientes->condicion = '1';
        $clientes->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Clientes::findOrFail($request->id);
        $categoria->condicion = '0';
        $categoria->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Clientes::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->save();
    }
}
