<?php

namespace App\Controller;

use App\Request\ProductDotRequest;

class ProductController extends Controller
{
    public function storeProduct(ProductDotRequest $request, $id)
    {
        $data = $request->init();
        var_dump($data, $id);
        die();
        //$this->response->setData($data)->send();
    }

}