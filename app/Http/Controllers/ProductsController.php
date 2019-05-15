<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        if ($products != null)
            return $products;
        else
            return response(
                [
                    "status" => "200",
                    "message" => 'Delete order success'
                ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $query = Product::insert($this->setValues($request));
        } catch (QueryException $ex) {
            return response(
                [
                    "status" => "401",
                    "message" => 'Data incorrect'
                ], 401
            );
        }
        if ($query) {
            return response(Product::all(), 200);
        } else {
            return response(
                [
                    "status" => "404",
                    "message" => 'Id not found'
                ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Product::find($id);
        if ($result == null) {
            return response([
                "status" => "404",
                "message" => "Product not exist"
            ], 404);
        } else
            return response($result, 200);
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
        if (Product::find($id) == null) {
            return response(
                [
                    "status" => "404",
                    "message" => 'Id not found'
                ], 404);
        } else {
            try {
                $query = Product::where('id', '=', $id)->update($this->setValues($request));;
            } catch (QueryException $ex) {
                return response(
                    [
                        "status" => "400",
                        "message" => 'Data incorrect'
                    ], 400
                );
            }

            return
                response(Product::find($id), 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = Product::destroy($id);
        if ($query == 0) {
            return response(
                [
                    "status" => "404",
                    "message" => 'Product not exist'
                ], 404);
        } else {
            return response(
                [
                    "status" => "200",
                    "message" => 'Delete successfully'
                ], 200);
        }
    }
    protected function setValues(Request $request)
    {
        $string = $request->getContent();
        $values = json_decode($string, true);
        return $values;
    }
}
