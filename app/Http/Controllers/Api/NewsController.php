<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Jobs\SendWelcomeEmail;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\News\NewsRepositoryInterface;
use App\Product;
use App\News;
use App\Repositories\News\NewsRepository;
use App\User;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Validator;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Carbon\Carbon;




class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//        $this->news = new NewsRepository();
//    }
    protected $productRepo;

    public function __construct()
    {
        $this->newsModel = new NewsRepository();
    }
    public function index($categoryId)
    {

        if (!$categoryId) {
      return response()->json([
          "success" => false,
          "message" => "Thiếu tham số"
      ]);
  }
        $limit =isset($_GET["limit"])?$_GET["limit"]:10 ;
        $offset = isset($_GET["offset"])?$_GET["offset"]:0 ;
        $keyword = isset($_GET["keyword"])?$_GET["keyword"]:"" ;
        $products = $this->newsModel->getPostByCategoryId($categoryId, $limit , $offset ,$keyword);
//        $user = Redis::set('post_' + 'categoryId'    , json_encode($products));
//        $products = $this->news->getNews();
        Cache::put('key', $products, 2);
        $value = Cache::get('key');
        Cache::increment('key2', 2);
        dd($value);
        return response()->json([
            "success" => true,
            "err" => 0,
            "message" => "Product List",
            "data" => $products,
            "status" => 1
        ]);
    }
    public function countPostCate(){
      $count = $this->newsModel->countPostCate();
      if ($count){
          return response()->json([
              "success" => true,
              "message" => "Post data successfully.",
              "data" => $count
          ]);
      }else{
          return response()->json([
              "err" => 1,
              "message" => "Fail load data."
          ]);
      }

    }

    public function detailPost(Request $request){
        $slug = $request->get("slug");
        if (!$slug) {
            return response()->json([
                "err" => 1,
                "message" => "Invalid data."
            ]);
  }else{
            $data = $this->newsModel->getDatabySlug($slug);
            if ($data){
                return response()->json([
                    "err" => 0 ,
                    "message" => "Get data success",
                    "data" => $data
                ]);
            }else{
                return response()->json([
                    "err" => 0 ,
                    "message" => "Get data fail",
                    "data" => $data
                ]);
            }
        }
    }
    public function listNewsByCate($categorySlug , Request $request){
        $categorySlug = $categorySlug;
        $limit = $request->get('limit') ? $request->get('limit') : 10;
        $offset = $request->get('offset') ? $request->get('offset') : 0;
        if (!$categorySlug) {
            return response()->json([
                "err" => 1,
                "message" => "Invalid params",
            ]);
        }else{
            $data = $this->newsModel->getDataBySlugNewCate($categorySlug , $limit , $offset , false);
            $count =  $this->newsModel->getDataBySlugNewCate($categorySlug , $limit , $offset , true);

            return response()->json([
                "err" => 0 ,
                "status" => 1,
                "data" => $data,
                "count" => [[
                    "countData" => $count,
                ]]
            ]);
        }
    }

    public function search(Request $request){
        $limit = $request->get("limit") ? $request->get("limit") : 10;
        $offset = $request->get("offset") ? $request->get("offset") : 0;
        $keyword = $request->get("keyword") ? $request->get("keyword") : "";
        $data = $this->newsModel->getDataSearch($keyword , $limit , $offset , false);
        $countSearch = $this->newsModel->getDataSearch($keyword , $limit , $offset , true);
        return response()->json([
            "err" => 0,
            "status" => 1,
            "data" => $data,
            "countRecord" => $countSearch
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product = Product::create($input);
        return response()->json([
            "success" => true,
            "message" => "Product created successfully.",
            "data" => $product
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        return response()->json([
            "success" => true,
            "message" => "Product retrieved successfully.",
            "data" => $product
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();
        return response()->json([
            "success" => true,
            "message" => "Product updated successfully.",
            "data" => $product
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            "success" => true,
            "message" => "Product deleted successfully.",
            "data" => $product
        ]);
    }

    public function create(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        $job = (new SendWelcomeEmail($user))->delay(Carbon::now()->addMinutes(10));
        dispatch($job);
        return $user;
    }
}
