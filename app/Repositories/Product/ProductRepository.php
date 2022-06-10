<?php
namespace App\Repositories\Product;

use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Repositories\Product\Product::class;
    }

    public function getProduct()
    {
        return $this->model->select("*")->take(5)->get();
    }
}
