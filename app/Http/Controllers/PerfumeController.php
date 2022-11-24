<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfume;

class PerfumeController extends Controller
{
    public function getPerfumes() {

        $perfumes = Perfume::all();

        return view( "perfumes", [
            "perfumes"=> $perfumes
        ]);

    }

    public function newPerfume(Request $request) {

        return view( "new_perfume" );
    }

    public function storePerfume( Request $request ) {

        print_r($request->all());
        $request->validate(
            [   
                'name'                  => 'required|min:2|max:50',
                'type'                  => 'required|min:2',
                'price'                 => 'required|regex:"^[0-9]"',
                
            ],
            [   
                'name.min'              => 'A névnek minimum 2 karakterből kell állnia!',
                'name.max'              => 'A névnek maximum 10 karakterből kell állnia!',
                'name.required'         => 'Kérlek adj meg nevet!',

                'type.min'              => 'A tipusnak minimum 2 karakterből kell állnia!',
                'type.required'         => 'Kérlek adj meg tipust!',

                'price.required'        => 'Kérlek adj meg árat!',
                'price.regex'           => 'Csak számot adhatsz meg!',
            
            ]);


        $perfume = new Perfume;

        $perfume->name = $request->name;
        $perfume->type = $request->type;
        $perfume->price = (string)$request->price;

        $perfume->save();

        return redirect( "/" );
    }

    public function editPerfume( $id ) {

        $perfume = Perfume::find( $id );

        return view( "edit_perfume", [
            "perfume" => $perfume
        ]);
    }

    public function updatePerfume( Request $request ) {
            $perfume = Perfume::where("name", $request->name)->first();
            $perfume->name = $request->name;
            $perfume->type = $request->type;
            $perfume->price = $request->price;

            $perfume->save();

            return redirect("/perfumes");
    }

    public function deletePerfume( $id ) {

        $perfume = Perfume::find( $id );
        $perfume->delete();

        return redirect( "/perfumes" );
    }
}
