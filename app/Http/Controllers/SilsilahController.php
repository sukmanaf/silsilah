<?php

namespace App\Http\Controllers;

use App\Models\Silsilah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class SilsilahController extends Controller
{

    public function index()
    {
        $data = Silsilah::latest()->get();
        return view('list', compact('data'));
    }

    public function getnama()
    {
        $data = Silsilah::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data'    => $data
        ], 200);
    }



    public function get()
    {
        //get data from table posts
        // $datas = Silsilah::latest()->get();
        $datas = DB::select("SELECT * FROM silsilahs");
        $data = array();
        foreach ($datas as $k => $v) {
            $data[$k] = [
                $k + 1, $v->Nama, $v->JenisKelamin, $v->Parent,
                '

             <a href="#" class="btn btn-warning" onclick="edit(' . $v->Id . ',event)"> Edit</a>
             <a href="#" class="btn btn-danger" onclick="hapus(' . $v->Id . ',event)"> Hapus</a>
            '
            ];
        }



        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data'    => $data
        ], 200);
    }



    public function edit($id)
    {
        $select = Silsilah::latest()->get();
        $data = DB::select('select * FROM Silsilahs
        WHERE Id = "' . $id . '" ');
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data'    => $data,
            'select'    => $select
        ], 200);
    }
    public function store(Request $request)
    {

        $post = $request->input();

        //set validation
        $validator = Validator::make($request->all(), [
            'Nama'   => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            //save to database
            $data = Silsilah::create([
                'Nama'     => $post['Nama'],
                'JenisKelamin'   => $post['JK'],
                'Parent'   => $post['Parent']
            ]);

            //success save to database
            if ($data) {
                $select = Silsilah::latest()->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Silsilah Created',
                    'data'    => $post,
                    'select'    => $select
                ], 201);
            }

            //failed save to database
            return response()->json([
                'success' => false,
                'message' => 'Silsilah Failed to Save',
            ], 409);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {
        $post = $request->input();
        // dd($post);
        //set validation
        $validator = Validator::make($request->all(), [
            'Nama'   => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            //find silsilah by ID
            $silsilah = Silsilah::findOrFail($id);

            if ($silsilah) {

                //update Silsilah
                Silsilah::where('id', $id)->update([
                    'Nama'     => $post['Nama'],
                    'JenisKelamin'   => $post['JK'],
                    'Parent'   => $post['Parent']
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Silsilah Updated',
                    'data'    => $silsilah,
                ], 200);
            }

            //data Silsilah not found
            return response()->json([
                'success' => false,
                'message' => 'Silsilah Not Found',
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }
    public function destroy($id)
    {
        //find post by ID
        $silsilah = Silsilah::findOrfail($id);

        if ($silsilah) {

            //delete post
            $silsilah::where('Id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Silsilah Deleted',
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Silsilah Not Found',
        ], 404);
    }

    public function tree()
    {
        $arr = DB::select("SELECT * FROM silsilahs");
        $new = array();
        foreach ($arr as $a) {
            $new[$a->Parent][] = $a;
        }
        $tree = $this->createTree($new, array($arr[0]));
        // print_r($tree);
        // dd($new);
        return response()->json($tree);
    }


    function createTree(&$list, $parent)
    {
        $tree = array();
        foreach ($parent as $k => $l) {
            // dd($l->Id);exit();
            if (isset($list[$l->Id])) {
                $l->children = $this->createTree($list, $list[$l->Id]);
            }
            $tree[] = $l;
        }
        return $tree;
    }

    function has_children($rows, $id)
    {
        foreach ($rows as $row) {
            if ($row->Parent == $id)
                return true;
        }
        return false;
    }
    function build_tree($rows, $parent = 0)
    {
        $result = "<ul>";
        foreach ($rows as $row) {
            if ($row->Parent == $parent) {
                $result .= "<li>{$row->Nama}";
                if ($this->has_children($rows, $row->Id))
                    $result .= $this->build_tree($rows, $row->Id);
                $result .= "</li>";
            }
        }
        $result .= "</ul>";

        return $result;
    }
    public function trees()
    {
        $arr = DB::select("SELECT * FROM silsilahs");

        $tree = $this->build_tree($arr);
        return response()->json($tree);
    }


    public function api()
    {
        $SemuaAnak = DB::select("SELECT * FROM silsilahs WHERE PARENT =1");
        $CucuBudi = DB::select("SELECT * FROM silsilahs WHERE PARENT !=1");
        $CucuPerempuanBudi = DB::select("SELECT * FROM silsilahs WHERE PARENT != 1 AND JenisKelamin ='P'");
        $BibiFarah = DB::select("SELECT * FROM silsilahs WHERE PARENT =1 AND JenisKelamin = 'P'");
        $SepupuLaki = DB::select("SELECT * FROM silsilahs WHERE PARENT != 1 AND JenisKelamin ='L'");
        $data['SemuaAnak'] = [
                                'success' => true,
                                'data'    => $SemuaAnak,
                            ];
        $data['CucuBudi'] = [
                                'success' => true,
                                'data'    => $CucuBudi,
                            ];;
        $data['CucuPerempuanBudi'] = [
                                        'success' => true,
                                        'data'    => $CucuPerempuanBudi,
                                    ];
        $data['BibiFarah'] = [
                                'success' => true,
                                'data'    => $BibiFarah,
                            ];
       $data['SepupuLaki'] = [
                                'success' => true,
                                'data'    => $SepupuLaki,
                            ];

        return response()->json($data);

    }
}
