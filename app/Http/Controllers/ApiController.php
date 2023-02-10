<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post as ModelPost;
use App\Models\User as ModelUser;
use App\Models\Comment as ModelComment;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller{
    public function manager(Request $request, $class_name, $func_name){
        
        $managedclasses = [
            'User' => (new User),
            'Post' => (new Post),
        ];
       
        try{           
            
            $tokenfromclient = $request->header('X-CSRF-TOKEN', 'default');
            $tokenfromserver = csrf_token();
            
            if ($tokenfromclient === $tokenfromserver){                              
                $response = ($managedclasses[ucfirst($class_name)])->$func_name($request);
                return $response;
            }else{
                $ret = [
                    'status' => '201',
                    'reason' => 'Invalid Token',
                    'data' => 'No err',
                ];
                return json_encode($ret);
            }


        } catch (\Throwable $th) {
            $ret = [
                'status' => '201',
                'reason' => $th->getMessage(),
                'data' => '',
            ];
            return json_encode($ret);
        }

    }

    public function test(Request $request){
        
        $user = new ModelUser;
        $user->name = "test1";
        $user->email = "test2@test.com";
        $user->password = "Hary";
        $user->gender = "fEAER";
        $user->role = "user";
        $user->likedproducts = "testlikes";

        
        try{
            $user->save();
        }catch(\Illuminate\Database\QueryException $ex){ 
            $ret = [
                'status' => '201',
                'reason' => $ex->getMessage(),
                'data' => '',
            ];
            return json_encode($ret);
        }

        $ret = [
            'test' =>'succesful'
        ];
        return json_encode($ret);      
    } 
    public function minitest(Request $request){
        // $post = new ModelPost;
            // $ret = [
            //     'test' =>csrf_token()
            // ];
            // $post->title = "Tha title";
            // $post->body = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique iure recusandae et in officia laborum aperiam soluta nesciunt quae dicta!";
            // $post->image = "data['image']"; 
            // $post->bio = json_encode([
            //     "time"=>"12:30",
            //     "category"=>"category",
            // ]);       
            // $post->comments = json_encode([
            //     "poster"=>"",
            //     "node1"=>[
            //         "name"=>"sjd",
            //         "node2"=>[
            //             "names"=>"Ojo JOhne",
            //             "node3"=>[
                            
            //             ]
            //         ]
            //     ]
            // ]);
            
            // $post->save();

            // $post = new ModelPost;

            // $redLovers = $post
            // ->where('id', '1')
            // ->get("comments->node1 as kk");
            

            // $kk = new \stdClass();
            // $kk->foo = 42;
            // $post->where('id', '1')
            //     ->update(['comments->node1->namef' =>  json_encode($kk)]);
                    
            // $redLovers = $post
            // ->where('id', '1')
            // ->get("comments->node1->namef->foo as ss")[0];

            // $ret = $redLovers->ss;
                // $redLovers = DB::table('posts')
                // ->where('id', '1')
                // ->get();
            // return 'Back';

            // $ret = [
            //     "name"=>"Ojo",
            //     "ets"=>""
            // ];

            // $test = [
            //     "new"=>"hey",
            //     "ssd"=>"jbsc"
            // ];

            // $ret["ets"] = $test;

            
            // $k = 'ret';
            // // $ret = 3;
            // $k = '
            //     $ret = [
            //         "sade"=>"newsade"
            //     ];
            // ';
            // eval('$ret["ts"]["tt"]["jhs"] = $test;');
        // $ret["ts"]["tt"]["jhs"] = 2;

        $test = [
            [
                'addr'=>"b|12",
                "name"=>"ojswo",
                "poster"=>"kk",
            ],
            [
                'addr'=>"b|3|3",
                "name"=>"ojosw",
                "poster"=>"kk",
            ],
            [
                'addr'=>"b|3|3|4|5|5|7",
                "name"=>"ojosw",
                "poster"=>"kk",
            ],
            [
                'addr'=>"b|3",
                "name"=>"ojosw",
                "poster"=>"kk",
            ],
            [
                'addr'=>"b|1",
                "name"=>"ojos",
                "poster"=>"kwk",
            ],
            [
                'addr'=>"b|2",
                "name"=>"ojswo",
                "poster"=>"kk",
            ]
        ];
        $ret = Post::dataSort($test);
        return (json_encode($ret));      
    }
    public function pagetest(Request $request){
        return view('test');      
    } 


    public function fetchtoken(Request $request, $apiaccesstoken){
        $ret = [
            'status'=>201,
            'error' => [
                'code'=>"Invalid Api Access Code"
            ]
        ];
        if ($apiaccesstoken == "alabi@auth.tuchdelta"){
            $ret = [
                'status'=>201,
                'request_token' =>csrf_token()
            ];
        }        
        // e0wgtea3uzOBC7PPBBt5CiAcstS4TKdWOipZJC0h
        return json_encode($ret);      
    }
}

class User{

    private $valset =  [
        'name' => ['required', 'min:4', 'max:35', 'string'],
        'email' => ['required', 'email'],
        'password' => ['required', 'min:5', 'max:25'],
        'code' => ['required'],
    ];
    

    public function create($request){
        $data = $request->all();       
        $data['code'] = '-';      

        $validator = Validator::make($data, [
            'name' => ['required', 'min:4', 'max:35', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:5', 'max:25'],
            'code' => ['required'],
        ]);

        if ($validator->fails()) {
            $ret = [
                'status' => 201,
                'data' => json_encode($validator->errors()->get('*')),
            ];
            return json_encode($ret);
        }
        

        if ($data['email'] == 'admin@tuchdelta.com'){
            $data['role'] = 'admin';
        }
        
        
        $user = [''];
        try{
            $user = ModelUser::where('email', $data['email'])->get();
        }catch(\Illuminate\Database\QueryException $ex){ 
            $ret = [
                'status' => 201,
                'reason' => $ex->getMessage(),
                'data' => '',
            ];
            return json_encode($ret);
        }     
        
        if (count($user) !== 0){
            $ret = [
                'status' => 201,
                'data' => [
                    'email' => 'Email Already exists'
                ],
            ];
            return json_encode($ret);
        }
        


        $user = new ModelUser;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];       
        $user->code = $data['code'];

        try{
            $user->save();

            $user->code =  Util::Encode($user->id, 4, 'str');
            $user->save();
        }catch(\Illuminate\Database\QueryException $ex){ 
            $ret = [
                'status' => '201',
                'reason' => $ex->getMessage(),
                'data' => '',
            ];
            return json_encode($ret);
        }
        
        $ret = [
            'status' => '200',
            'data' => [
                'user' =>  $user->code,
            ],
        ];
        return json_encode($ret);
        
    }

    public function update($request){
        $data = $request->all();

        $updset = ($data['updset']);
        $querypair = ($data['querypair']);

        unset($updset['code']);
        unset($updset['email']);// Another code to 

        
        $updvalidator = [];

        foreach($updset as $key => $val){
            if (isset($this->valset[$key])){
                $updvalidator[$key] = $this->valset[$key];
            }else{
                unset($updset[$key]);
            }
        }

        $validator = Validator::make($updset, $updvalidator);
        if ($validator->fails()) {
            $ret = [
                'status' => '201',
                'reason' => 'valerror',
                'data' => json_encode($validator->errors()->get('*')),
            ];
            return json_encode($ret);
        }
        
        try{
            $user = ModelUser::where($querypair)->get(['code']);
        }catch(\Illuminate\Database\QueryException $ex){ 
            $ret = [
                'status' => '201',
                'reason' => $ex->getMessage(),
                'data' => '',
            ];
            return json_encode($ret);
        }

        
        
        if (count($user) === 0){
            $ret = [
                'status' => '201',
                'data' => 'User not found',
            ];
            return json_encode($ret);
        }

        $user = ModelUser::where($querypair)->first();

        
        foreach($updset as $key => $val){
            $user->$key = $val;
        }
        
        try{
            $user->save();
        }catch(\Illuminate\Database\QueryException $ex){ 
            $ret = [
                'response' => 'failed',
                'reason' => $ex->getMessage(),
                'data' => '',
            ];
            return json_encode($ret);
        }

        $ret = [
            'response' => 'passed',
            'data' => [
                'user' => $user->code
            ],
        ];
        return json_encode($ret);
        
    }

    private function cleanArray($arr, $remove){

        $ret = [];
        $arr = array_diff($arr, $remove);
        foreach ($arr as $vals) {
            array_push($ret, $vals);
        }
        return ($ret);
    }


    public function fetch($request){
        $data = $request->all();

        $fetchset =  $data['fetchset'];
        $querypair =  $data['querypair'];

        $fetchset = $this->cleanArray($fetchset, ['id', 'password']);

        try{
            $model = ModelUser::select($fetchset)->where($querypair)->get();
            $ret = [
                'response' => '200',
                'data' => $model,
            ];
            return json_encode($ret);
        }catch(\Illuminate\Database\QueryException $ex){ 
            $ret = [
                'response' => '201',
                'data' => 'Invalid query',
            ];
            return json_encode($ret);
        }
                
    }
    
    public function validate($request){
        $data = $request->all();

        
        $validator = Validator::make($data, [
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            $ret = [
                'status' => '201',
                'reason' => 'Value error',
                'data' => json_encode($validator->errors()->get('*')),
            ];
            return json_encode($ret); 
        }        
               
        
        try{
            $user = ModelUser::where([
                    ['email', $data['email']], 
                    ['password', $data['password']] 
            ])->get(['code', 'name']);

            if (isset($user[0])){
                $user = $user[0];
            }else{
                $user = null;
            }
            

        }catch(\Illuminate\Database\QueryException $ex){ 
            $ret = [
                'status' => '201',
                'reason' => $ex->getMessage(),
                'data' => 'here',
            ];
            return json_encode($ret);
        }
        

        if (!isset($user)){
            $ret = [
                'status' => '201',
                'data' => 'User not found',
            ];
            return json_encode($ret);
        }


        $ret = [
            'response' => 'passed',
            'data' => [
                'user' =>  $user['code'],
                'name' =>  $user['name']
            ],
        ];
        return json_encode($ret);
        
    }
    
    
    
}

class Post{

    private $valset =  [
        'title' => ['required', 'min:4', 'max:35', 'string'],
        'author_code' => ['required'],
        'body' => ['required'],
    ];

    //Post
     
    public function create($request){
        $data = $request->all();

        // $data = (array) json_decode($datapack['createset']);   
        $data['post_code'] = '-';
        $data['image'] = json_encode([]);

        //Other data check
        $validator = Validator::make($data, $this->valset);
        if ($validator->fails()) {
            $ret = [
                'status' => 201,
                'data' => json_encode($validator->errors()->get('*')),
            ];
            return json_encode($ret);
        }        

        $model = new ModelPost;
        foreach($data as $key => $val){
            $model->$key = $val;
        }

        try{
            $model->save();

            $model->post_code =  Util::Encode($model->id, 4, 'str');
            $model->save();

        }catch(\Illuminate\Database\QueryException $ex){ 
            $ret = [
                'status' => '201',
                'reason' => $ex->getMessage(),
                'data' => 'hh',
            ];
            return json_encode($ret);
        }
        
        $ret = [
            'status' => '200',
            'data' => [
                'post_code' =>  $model->post_code
            ],
        ];
        return json_encode($ret);
        
    }

    public function fetchpost($request){
        $data = $request->all();

        $fetchset =  $data['fetchset'];
        $querypair =  $data['querypair'];

        $fetchset = $this->cleanArray($fetchset, ['id', 'password']);

        try{
            $model = ModelPost::select($fetchset)->where($querypair)->get();
            $ret = [
                'response' => '200',
                'data' => $model,
            ];
            return json_encode($ret);
        }catch(\Illuminate\Database\QueryException $ex){ 
            $ret = [
                'response' => '201',
                'data' => 'Invalid query',
            ];
            return json_encode($ret);
        }
                
    }

    public function fetchposts($request){
        $data = $request->all();

        $valset =  [
            'max_count' => ['required'],
        ];
        $validator = Validator::make($data, $valset);
        if ($validator->fails()) {
            $ret = [
                'status' => 201,
                'data' => json_encode($validator->errors()->get('*')),
            ];
            return json_encode($ret);
        }

        $count = ($data['max_count']); 
      

        // get the last count from posts
        $posts = ModelPost::latest()->take($count)->get();

        $ret = [
            'response' => 'passed',
            'data' => $posts,
        ];
        return $ret;
        
    }

    public function update($request){
        $data = $request->all();

        $updset = ($data['updset']);
        $querypair = ($data['querypair']);

        unset($updset['code']);
        unset($updset['comments']);

        $updvalidator = [];

        foreach($updset as $key => $val){
            if (isset($this->valset[$key])){
                $updvalidator[$key] = $this->valset[$key];
            }else{
                unset($updset[$key]);
            }
        }

        $validator = Validator::make($updset, $updvalidator);
        if ($validator->fails()) {
            $ret = [
                'status' => '201',
                'reason' => 'valerror',
                'data' => json_encode($validator->errors()->get('*')),
            ];
            return json_encode($ret);
        }
        
        
        $post = ModelPost::where($querypair)->first();
        
        foreach($updset as $key => $val){
            $post->$key = $val;
        }
        
        try{
            $post->save();
        }catch(\Illuminate\Database\QueryException $ex){ 
            $ret = [
                'response' => 'failed',
                'reason' => $ex->getMessage(),
                'data' => '',
            ];
            return json_encode($ret);
        }

        $ret = [
            'response' => 'passed',
            'data' => [
                'post_code' => $post->code
            ],
        ];
        return json_encode($ret);
        
    }

    public function deletepost($request){
        $data = $request->all();        
        
        $valset =  [
            'querypair' => ['required'],
        ];
        $validator = Validator::make($data, $valset);
        if ($validator->fails()) {
            $ret = [
                'status' => '201',
                'reason' => 'valerror',
                'data' => json_encode($validator->errors()->get('*')),
            ];
            return json_encode($ret);
        }

        $querypair = ($data['querypair']);        
        $post = ModelPost::where($querypair)->first();
        if (!isset($post)){
            $ret = [
                'response' => 'failed',
                'reason' => "Query does not match any entries",
                'data' => '',
            ];
            return json_encode($ret);
        }
        
        $post_code =  $post->post_code;
                
        try{
            $post->delete();
            $comment = ModelComment::where([
                ["post_code", $post_code],
            ])->delete();
        }catch(\Illuminate\Database\QueryException $ex){ 
            $ret = [
                'response' => 'failed',
                'reason' => $ex->getMessage(),
                'data' => '',
            ];
            return json_encode($ret);
        }

        $ret = [
            'response' => 'deleted',
            'data' => [
                'deleted_post_code' => $post_code
            ],
        ];
        return json_encode($ret);
        
    }
    
    //Comments

    public function addcomment($request){
        $data = $request->all();

        $valset =  [
            'post_code' => ['required'],
            'parent_address' => ['required'],
            'author_code' => ['required'],
            'text' => ['required', 'min:4', 'max:100'],
        ];
        $validator = Validator::make($data, $valset);
        if ($validator->fails()) {
            $ret = [
                'status' => 201,
                'data' => json_encode($validator->errors()->get('*')),
            ];
            return json_encode($ret);
        }   

        $post_code = ($data['post_code']); 
        $par_addr = ($data['parent_address']); // Encoded code_0|4 whatever
        $addr = '';
        $author_code = $data['author_code'];
        $text = $data['text'];   
        
        $l_index = 0;

        if ($par_addr == 'base'){        
            $ins_index = ModelPost::where("post_code", $post_code)->get(['direct_comment_count'])[0]["direct_comment_count"];      
            $ins_index += 1;    
            
            $addr = "base|".($ins_index);
            ModelPost::where("post_code", $post_code)->update(['direct_comment_count'=>$ins_index]);
        }else{            
            $par_addr = Util::Decode($par_addr, strlen($par_addr), 'multi');
            
            $ins_index = ModelComment::where(
                    [["post_code", $post_code], ["address", $par_addr]]
                )->get(['direct_comment_count'])[0]["direct_comment_count"];

            $ins_index += 1;
            $addr = $par_addr."|".($ins_index);
            
            // Exploding "base|2" will return 2
            $l_index = count(explode("|", $par_addr)) - 1;//Knowing well that index start from 0

            ModelComment::where(
                [["post_code", $post_code], ["address", $par_addr]]
            )->update(['direct_comment_count'=>$ins_index]);
        }

        $com = new ModelComment;
        $com->text = $text;
        $com->post_code = $post_code;
        $com->author_code = $author_code;
        $com->address = $addr;
        $com->text = $text;
        $com->layer_index = $l_index;

        try{
            $com->save();
        }catch(\Illuminate\Database\QueryException $ex){ 
            $ret = [
                'status' => '201',
                'reason' => $ex->getMessage(),
                'data' => '',
            ];
            return json_encode($ret);
        }

        $ret = [
            'response' => 'passed',
            'data' => [
                'address' => Util::Encode($addr, strlen($addr), 'multi')
            ],
        ];
        return json_encode($ret);
        
    }

    public function fetchnodecomments($request){
        $data = $request->all();
        // Prepend % if it can have texts before and Append vis

        $valset =  [
            'post_code' => ['required'],
            'node_address' => ['required'],
            // 'max_count' => ['required'],
            // 'max_layer_depth' => ['required'],
        ];
        $validator = Validator::make($data, $valset);
        if ($validator->fails()) {
            $ret = [
                'status' => 201,
                'data' => json_encode($validator->errors()->get('*')),
            ];
            return json_encode($ret);
        }   

        $post_code = ($data['post_code']); 
        $node_addr = ($data['node_address']); 

        if ($node_addr != "base"){
            $node_addr = Util::Decode($node_addr, strlen($node_addr), "multi");
        }

        $comment = '';
        if (isset($data['max_count'])){
            $max_count = $data['max_count'];            

            if (isset($data['max_layer_depth'])){
                $comment = [];
                $x = 1;
                $req_depth = $data['max_layer_depth'];
                while(count($comment) <= $max_count && $x <= $req_depth){
                    $depth = count(explode("|", $node_addr)) + $x - 2;
                    $sub_comment = ModelComment::where([
                        ["address", "LIKE", $node_addr.'|'.'%'],
                        ["post_code", $post_code],
                        ["layer_index", $depth],
                    ])->latest()->take($max_count - count($comment))->get();

                    if (count($sub_comment) == 0){
                        break;
                    }
                    array_push($comment, ...$sub_comment);
                    $x++;
                }   
            }else{                
                $comment = [];
                $x = 1;

                while(count($comment) <= $max_count){
                    $depth = count(explode("|", $node_addr)) + $x - 2;
                    $sub_comment = ModelComment::where([
                        ["address", "LIKE", $node_addr.'|'.'%'],
                        ["post_code", $post_code],
                        ["layer_index", $depth],
                    ])->latest()->take($max_count - count($comment))->get();

                    if (count($sub_comment) == 0){
                        break;
                    }
                    array_push($comment, ...$sub_comment);
                    $x++;
                }
            }
        }else{
            if (isset($data['max_layer_depth'])){                
                $depth = count(explode("|", $node_addr)) + $data['max_layer_depth'] - 2;

                $comment = ModelComment::where([
                    ["address", "LIKE", $node_addr.'|'.'%'],
                    ["post_code", $post_code],
                    ["layer_index", "<=" ,$depth],
                ])->get();
            }else{
                $comment = ModelComment::where([
                    ["address", "LIKE", $node_addr.'|'.'%'],
                    ["post_code", $post_code],
                ])->get();
            }
        }     
        
        $comment = json_decode(json_encode($comment), true);      

        $comment_to_json = $this->dataSort($comment, $node_addr);
        
        $ret = [
            'response' => 'passed',
            'comment_data' => [
                'address'=>$node_addr,
                'replies' => $comment_to_json
            ],
        ];
        return $ret;
        
    }
    
    public function deletecomment($request){
        $data = $request->all();

        $valset =  [
            'address' => ['required'],
            'post_code' => ['required'],
        ];
        $validator = Validator::make($data, $valset);
        if ($validator->fails()) {
            $ret = [
                'status' => 201,
                'data' => json_encode($validator->errors()->get('*')),
            ];
            return json_encode($ret);
        }   

        $addr = $data['address'];
        $post_code = $data['post_code'];
        
        //delete all comment that starts with the address
        $comment = ModelComment::where([
            ["address", "LIKE", $addr .'%'],
            ["post_code", $post_code],
        ])->get();

        $ret = [
            'response' => 'deleted',
            'data' => [
                'deleted_comment_addr'=>$addr,
            ],
        ];
        return $ret;
        
    }

    // Util

    private function cleanArray($arr, $remove){

        $ret = [];
        $arr = array_diff($arr, $remove);
        foreach ($arr as $vals) {
            array_push($ret, $vals);
        }
        return ($ret);
    }
    private static function dataSort($dataArr, $startlayer){
        /*
            Given dataArr in the form 
            [
                {address:base|2|23, t:"gdh"},
                {address:base|1, t:"gdh"},
                {address:base|2|23, t:"gdh"},
                {address:base|3|23, t:"gdh"},
                {address:base|2|2, t:"gdh"},
                {address:base|2, t:"gdh"}
            ]
            This function sorts the array in a proper json hierachy   
            e.g above should return 
            {
                ...
                1:{
                    last_reply_index:-1
                    adress:b|1
                    replies:{

                    }
                }
                2:{
                    last_reply_index:2
                    adress:b|2
                    replies:{
                        2:{
                            last_reply_index:-1
                            adress:b|2
                            replies:{
                                
                            }
                        }
                    }
                }
                ...
            }   

            $startlayer is the address of the comment layer the search is indexing from
            $max_pack is the maximum number of comment in the pack
        */

        $data_node ='';
        $addrlevels = explode("|", $startlayer);
        foreach ($addrlevels as $lv) {
            $data_node .= "['".$lv."']['replies']";
        }

        $retArr = [];

        foreach ($dataArr as $c_pack) {
            // Get the "b|0|2..."
            $addr = $c_pack["address"];

            $addrlevels = explode("|", $addr);            
            $depth = count($addrlevels);
            $last = $addrlevels[$depth-1];

            //Removes the last from the set
            $addrlevels =  array_slice($addrlevels, 0, $depth-1);

            
            $depth_string = '';

            foreach ($addrlevels as $lv) {
                $depth_string .= "['".$lv."']['replies']";
            }
            $depth_string .= "['".$last."']";
            
            $cnode_data = [];
            foreach($c_pack as $key=>$data){
                $cnode_data[$key] = $data;
            }
            
            $eval_string = '$retArr'.$depth_string.'["bio"] = $cnode_data;';
            
            eval($eval_string);


            
        }

        
        eval('
            $retArr = $retArr'.$data_node.';
        ');

        return $retArr;       

    }   

}


class Util{
    public static function Encode($code, $encNum, $type){
        $join = '';
        for ($i = 0; $i < $encNum - strlen($code); $i++) {
            $join .= '0';
        }
        $code = $join . $code;

        $Res = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        if ($type == 'str'){
            $Res = 'ZgBoFklNOaJKLM5XYh12pqr6wQRSTdefijAPbcU4mnVW0stuv78xyzGCDE3HI9';
        }  
        if ($type == 'multi'){
            $Res = 'ZgBoFklNOaJKLM5XYh12pqr6wQRSTdefijAPbcU4mnVW0stuv78xyzGCDE3HI9|';
        }        
        $tlenght = strlen($Res);
        $rtl = '';
        for ($i = 0; $i < strlen($code); $i++) {
            $el = $code[$i];
            $k = (strpos($Res, $el) + $encNum + $i) % $tlenght;
            $rtl .=  substr($Res, $k, 1);
        }
        return $rtl;
    }
    public static function Decode($code, $encNum, $type){
        $Res = 'ZgBoFklNOaJKLM5XYh12pqr6wQRSTdefijAPbcU4mnVW0stuv78xyzGCDE3HI9';
        if ($type == 'int'){
            $Res = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        }  
        if ($type == 'multi'){
            $Res = 'ZgBoFklNOaJKLM5XYh12pqr6wQRSTdefijAPbcU4mnVW0stuv78xyzGCDE3HI9|';
        }
        $tlenght = strlen($Res);
        $rtl = '';
        for ($i = 0; $i < strlen($code); $i++) {
            $el = $code[$i];
            $k = (strpos($Res, $el) - $encNum - $i + $tlenght) % $tlenght;
            $rtl .=  substr($Res, $k, 1);
        }
        return $rtl;
    }

    
    public function cleanArray($arr, $remove){

        $ret = [];
        $arr = array_diff($arr, $remove);
        foreach ($arr as $vals) {
            array_push($ret, $vals);
        }
        return ($ret);
    }
}