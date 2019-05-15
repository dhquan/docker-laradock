<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getAllProduct()
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

    public function getById($product_id)
    {
        $result = Product::find($product_id);
        if ($result == null) {
            return response([
                "status" => "404",
                "message" => "Product not exist"
            ], 404);
        } else
            return response($result, 200);
    }

    public function deleteById($product_id)
    {

        $query = Product::destroy($product_id);
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

    public function updateById(Request $request, $product_id)
    {

        if (Product::find($product_id) == null) {
            return response(
                [
                    "status" => "404",
                    "message" => 'Id not found'
                ], 404);
        } else {
            try {
                $query = Product::where('id', '=', $product_id)->update($this->setValues($request));;
            } catch (QueryException $ex) {
                return response(
                    [
                        "status" => "400",
                        "message" => 'Data incorrect'
                    ], 400
                );
            }

            return
                response(Product::find($product_id), 200);
        }

    }

    public function create(Request $request)
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

    protected function setValues(Request $request)
    {
        $string = $request->getContent();
        $values = json_decode($string, true);
        return $values;
    }
}