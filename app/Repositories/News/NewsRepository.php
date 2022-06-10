<?php
namespace App\Repositories\News;
//use Illuminate\Support\Facades\DB;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class NewsRepository extends BaseRepository implements NewsRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
        define('TABLE_NAME_CATEGORY', 'data_news_version_2_category');
        define('TABLE_NAME_POST' , 'data_news_version_2_posts');
    }
    //lấy model tương ứng
    public function getModel()
    {
        return \App\News::class;
    }

    public function getProduct()
    {
        return $this->model->select("*")->take(5)->get();
    }
    public function getPostByCategoryId($categoryId , $limit = 10 , $offset = 0 , $keyword)
    {

        return $this->model->select("*")
            ->where('categoryId', $categoryId)
            ->where('name','LIKE','%'.$keyword.'%')
            ->offset($offset)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getDataBySlugNewCate($categorySlug , $limit = 10 , $offset = 0 , $checkCount = true){
        $categoryList = DB::table(TABLE_NAME_CATEGORY)->select("id")->where("slugs"  , $categorySlug)->get();
        $categoryListConvert = [];
        foreach ($categoryList as $key=>$value){
            $categoryListConvert[] = $value->id;
        }
         if (!$checkCount){
             $return = $this->model->select(TABLE_NAME_POST.'.title' ,
                 TABLE_NAME_CATEGORY . '.name as nameCate' ,
                 TABLE_NAME_POST . '.name' ,
                 TABLE_NAME_POST . '.id' ,
                 TABLE_NAME_POST . '.description',
                 TABLE_NAME_POST . '.thumb',
                 TABLE_NAME_POST . '.photo',
                 TABLE_NAME_POST . '.slugs',
                 TABLE_NAME_POST . '.photo_data',
                 TABLE_NAME_POST . '.categoryId',
                 TABLE_NAME_POST . '.created_at')
                 ->leftJoin(TABLE_NAME_CATEGORY, TABLE_NAME_POST . '.categoryId', '=', TABLE_NAME_CATEGORY . '.id')
                 ->whereIn(TABLE_NAME_POST.'.categoryId' , $categoryListConvert )
                 ->offset($offset)
                 ->limit($limit)
                 ->orderBy('id', 'desc')
                 ->get();
         }else{
             $return = $this->model
                 ->leftJoin(TABLE_NAME_CATEGORY, TABLE_NAME_POST . '.categoryId', '=', TABLE_NAME_POST . '.id')
                 ->whereIn(TABLE_NAME_POST.'.categoryId' , $categoryListConvert )
                 ->offset($offset)
                 ->limit($limit)
                 ->orderBy('id', 'desc')
                 ->count();
         }

            return $return;
//        SELECT data_news_version_2_posts.title , data_news_version_2_posts.name , data_news_version_2_posts.id , data_news_version_2_posts.description, data_news_version_2_posts.thumb , data_news_version_2_posts.photo ,  data_news_version_2_posts.slugs , data_news_version_2_posts.photo_data , data_news_version_2_posts.categoryId , data_news_version_2_posts.created_at ,data_news_version_2_category.NAME AS nameCate FROM data_news_version_2_posts
//         LEFT JOIN data_news_version_2_category ON data_news_version_2_posts.categoryId = data_news_version_2_category.id
//         WHERE categoryId IN ( SELECT id FROM data_news_version_2_category WHERE slugs = '" +
//              categorySlug +
//              "' )
    }

    public function getDataSearch($keyword , $limit , $offset , $checkCount = false){

        if (!$checkCount){
        $result  =  $this->model->select(TABLE_NAME_POST . '.title',
                TABLE_NAME_POST . '.title',
                TABLE_NAME_POST . '.name',
                TABLE_NAME_POST . '.id',
                TABLE_NAME_POST . '.categoryId',
                TABLE_NAME_POST . '.created_at',
                TABLE_NAME_POST . '.thumb',
                TABLE_NAME_POST . '.photo',
                TABLE_NAME_POST . '.photo_data',
                TABLE_NAME_POST . '.slugs',
                TABLE_NAME_POST . '.description'
            )
                ->where('title','LIKE','%'.$keyword.'%')
                ->offset($offset)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();
        }else{
            $result  =  $this->model
                ->where('title','LIKE','%'.$keyword.'%')
                ->offset($offset)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->count();
        }
    return $result;
    }

    public function countPostCate(){
        return  $this->model
            ->join(TABLE_NAME_CATEGORY, TABLE_NAME_POST.'.categoryId', '=', TABLE_NAME_CATEGORY.'.id')
            ->groupBy( TABLE_NAME_POST.'.categoryId')
//            ->selectRaw('')
            ->select(TABLE_NAME_CATEGORY.'.slugs' , $this->model->raw('count(*) as countPost, '.TABLE_NAME_CATEGORY.'.id') ,TABLE_NAME_CATEGORY.'.name' )
            ->get();
        //SELECT data_news_version_2_category.name  , count(data_news_version_2_posts.id) as countPost , data_news_version_2_category.slugs from data_news_version_2_posts INNER JOIN data_news_version_2_category ON data_news_version_2_posts.categoryId = data_news_version_2_category.id GROUP BY data_news_version_2_posts.categoryId
    }
    public function getDatabySlug($slug){
        return $this->model->select("*")
            ->where('slugs' , $slug)
            ->get();
    }
}
