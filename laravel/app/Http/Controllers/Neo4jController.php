<?php
/**
 * Created by PhpStorm.
 * User: kittytian
 * Date: 2018/11/4
 * Time: 下午5:37
 */
namespace App\Http\Controllers;

//require_once '../vendor/autoload.php';
use Illuminate\Http\Request;
use GraphAware\Neo4j\Client\ClientBuilder;

class Neo4jController extends Controller {

    public function search(Request $request)
    {

        $teacherName = $request->input('teacherName');

        $client = ClientBuilder::create()
            ->addConnection('bolt', 'bolt://neo4j:12345678@10.3.55.50:7687')
            ->build();
        $query = "MATCH (n:Teacher{name:'{$teacherName}'}) RETURN n";
        $result = $client->run($query);

        foreach ($result->getRecords() as $record) {
            print_r($record->values());
        }

    }
    public function index(){
        return view("index");
    }


}
