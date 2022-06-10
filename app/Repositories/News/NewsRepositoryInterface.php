<?php
namespace App\Repositories\News;

use App\Repositories\RepositoryInterface;

interface NewsRepositoryInterface extends RepositoryInterface
{
    //ví dụ: lấy 5 sản phầm đầu tiên
    public function getProduct();
}
