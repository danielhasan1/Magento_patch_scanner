<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JonnyW\PhantomJs\Client;
use App\Post;
use \RecursiveIteratorIterator;
use \RecursiveArrayIterator;
use Illuminate\Support\Facades\DB;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $history = Post::orderBy('created_at','desc')->paginate(10);
        //return Post::all();
        return view('pages.index')->with('hist',$history);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function create()
    {
        return "<h1>Page Not Found 404</h1>";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request_st)
    {
        //
        $post = new Post;
        $post->title = $request_st->input('title');
        $post->body = 'Def';
        $this->validate($request_st, [
            'title'=>'required',  
        ]);
         //return "no";
       
    $client = Client::getInstance();
        
    
    $client = Client::getInstance();
    $client->getEngine()->setPath(dirname(__FILE__).'/bin/phantomjs.exe');
    $client->isLazy(); //if taking more time to load
    $request  = $client->getMessageFactory()->createRequest();
    $response = $client->getMessageFactory()->createResponse();
    $request->setMethod('GET');
    $check_con=@file_get_contents('https://www.magereport.com/scan/result/?s='.$post->title);
    
    
    if($check_con === False){
        //checking if this url exist or not if not then magento will return 408
        return view('errors.404');
    }
    $request->setUrl('https://www.magereport.com/scan/?s='.$post->title);
    $client->send($request, $response);
   
    //can add if clause if request isnt 200ok to reroute for refreshing or again submiting
    if($response->getStatus() === 200){
        if (DB::table('posts')->where('title', $request_st->input('title'))->count() === 0) {
            // user for checking if exist so don't add
            // giving default for now but can add results so if needed not required to process results again can
            $post->save();
         }
    $jsons= file_get_contents('https://www.magereport.com/scan/result/?s='.$post->title);
    $json=$response->getContent();
    $temp = array();
    $pd = new \DOMDocument();
    libxml_use_internal_errors(TRUE);
    if(!empty($json)){ //if any html is actually returned

        $pd->loadHTML($json);
        libxml_clear_errors(); //remove errors for yucky html

        $pokemon_xpath = new \DOMXPath($pd);
        $json_prep = array();
        $json_key =array();
       
        $not_conc = array();
        $raw = $pokemon_xpath->query('//article/dl');//taking only patch names
        $details = $pokemon_xpath->query('//article');// taking all the content with names
        
        
        $mystring = '';
        $findme   = 'security.';
        $pos = strpos($jsons, $findme);
        
        $temp = '{"';
        $pos = $pos+9;
        $json_maker='';
        $entry='';
        
        while($pos<strlen($jsons)){
            
            $j=1;
            $entry_swtich = 1;
            while($j){
                if($jsons[$pos]==='{'){
                    $j++;
                }
                if($jsons[$pos]==='}'){
                    $j--;
                }
                if($jsons[$pos]==='s' && $jsons[$pos+1] === 'u' && $jsons[$pos+2] === 'p' && $jsons[$pos+3] === 'e' && $jsons[$pos+4]==='e'){
                    $pos = $pos+5;
                }
                $temp .=$jsons[$pos];
                if($entry_swtich){
                    $json_maker .= $jsons[$pos];
                    if($jsons[$pos+1]==='"' && $jsons[$pos+2]===':'){
                        $entry_swtich = 0;
           
           
                    }
                }
                $pos++;
               
            }
           // echo $temp."\n";
            $pos = $pos+11;
            $json_prep[] = json_decode($temp);
            $temp = '{"';
            $json_key[]=$json_maker;
            $json_maker = '';
        }
        //echo $arr;
        
        }
       
        $data = array(
            'key' => $json_key,
            'val' => $json_prep,
            'raw' => $raw,
            'detail'=> $details
        );
        return view('pages.results')->with($data);
        }
        //return $json_key[0];
                        
                      
                else { return "<h1> Refresh Or Submit Again. if still occurs then maybe Due to Slow Server Response/Timeout? Or Possibly wrong URL.</h1> ";}    
                   
            
        //return redirect('/post/create/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        return "<h1>Page Not Found 404</h1>";
        //not required for not/ not neccessary. can be integrated after saving the results into db.
        $single_hist =Post::find($id);
        return view('pages.details')->with('single',$single_hist);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return "<h1>Page Not Found 404</h1>";
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
        //not required for now
        return "<h1>Page Not Found 404</h1>";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //not required 
        return "<h1>Page Not Found 404</h1>";
    }
}
