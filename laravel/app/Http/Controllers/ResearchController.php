<?php

namespace App\Http\Controllers;

//require_once '../vendor/autoload.php';

use Illuminate\Http\Request;
use GraphAware\Neo4j\Client\ClientBuilder;

class ResearchController extends Controller
{

    public function rdetail(Request $request) 
    {
        if(!$request->has('name'))
        {
            dd('no name');
        }
        $name=$request->input('name');

        $client = ClientBuilder::create()
            ->addConnection('bolt', 'bolt://neo4j:12345678@10.3.55.50:7687')
            ->build();
        $query = "match (n:ResearchDirection)<-[r]-(t:Teacher) where n.content=~'.*(?i)" . "{$name}"  . ".*' return distinct n,t";
        $result = $client->run($query);
		
        $graph = array();
        $graph["nodes"] = array();
        $graph["links"] = array();
        $hasResearchName = array();
        $hasTeacherName = array();
        $nbresearch = 0;
        $nbteacher = 0;
        $nbresearchteacher = array();
        // $hasOthercName = array();
        foreach ($result->getRecords() as $record) {
            $record = (array)$record;
            $value_research = (array)$record["\0*\0values"][0];
            $research = array('');
            foreach($value_research["\0*\0properties"] as $x=>$x_value) {
                $research[$x] = $x_value;
            }
            $value_teacher = (array)$record["\0*\0values"][1];
            $teacher = array('');
            foreach($value_teacher["\0*\0properties"] as $x=>$x_value) {
                $teacher[$x] = $x_value;
            }
            /*
            $value_otherc = (array)$record["\0*\0values"][2];
            $otherc = array('');
            foreach($value_otherc["\0*\0properties"] as $x=>$x_value) {
                $otherc[$x] = $x_value;
            } */
            $node = array();
            if(in_array($research["content"], $hasResearchName) == False) {
                $node["name"] = $research["content"];
                $node["category"] = "研究方向";
                $node["symbolSize"] = 30;
                /* $node["tooltip"] = array();
                $node["tooltip"]["formatter"] = '{b0}:{c0}';
                $node["value"] = array();
                if(isset($course["faculty"]))
                    array_push($node["value"], $course["faculty"]);
                if(isset($course["major"]))
                    array_push($node["value"], $course["major"]); */
                array_push($graph["nodes"], $node);
                array_push($hasResearchName, $research["content"]);
                $nbresearch++;
                $nbresearchteacher[$research["content"]] = 0;
            }
            $node = array();
            if(in_array($teacher["name"], $hasTeacherName) == False) {
                $node["name"] = $teacher["name"];
                $node["category"] = "教师";
                $node["symbolSize"] = 15;
                $node["tooltip"] = array();
                $node["tooltip"]["formatter"] = '{b0}:{c0}';
                $node["value"] = array();
                if(isset($teacher["professional_title"]))
                    array_push($node["value"], $teacher["professional_title"]);
                if(isset($teacher["teacher_status"]))
                    array_push($node["value"], $teacher["teacher_status"]);
                if(isset($teacher["lab"]))
                    array_push($node["value"], $teacher["lab"]);
                if(isset($teacher["department"]))
                    array_push($node["value"], $teacher["department"]);
                if(isset($teacher["team"]))
                    array_push($node["value"], $teacher["team"]);
                array_push($graph["nodes"], $node);
                array_push($hasTeacherName, $teacher["name"]);
                $nbteacher++;
                // $nbresearchteacher[$research["content"]]++;
            }
            $nbresearchteacher[$research["content"]]++;
            /* $node = array();
            if(isset($otherc["name"]) and in_array($otherc["name"], $hasOthercName) == False) {
                if($otherc["name"]=='')
                    dd("error");
                $node["name"] = $otherc["name"];
                $node["category"] = "其他课程";
                $node["symbolSize"] = 10;
                $node["tooltip"] = array();
                $node["tooltip"]["formatter"] = '{b0}:{c0}';
                $node["value"] = array();
                if(isset($otherc["faculty"]))
                    array_push($node["value"], $otherc["faculty"]);
                if(isset($otherc["major"]))
                    array_push($node["value"], $otherc["major"]);
                array_push($graph["nodes"], $node);
                array_push($hasOthercName, $otherc["name"]);
                // dd($node); 
            } */
            
            $link = array();
            $link["source"] = $teacher["name"];
            $link["target"] = $research["content"];
            if(in_array($link, $graph["links"])==False)
                array_push($graph["links"], $link);
            /* $link2 = array();
            $link2["source"] = $course["name"];
            $link2["target"] = $otherc["name"];
            if(in_array($link2, $graph["links"])==False)
                array_push($graph["links"], $link2);
             */
        }
        $nbarr = array();
        $nbarr["research"] = $nbresearch;
        $nbarr["teacher"] = $nbteacher;
        $nbarr["nbresearchteacher"] = $nbresearchteacher;
        // dd($name);
        $view = 'demo.researchDetail';
        //dd($nbarr);
        //dd($hasResearchName);
        return view($view)->with(['name'=>$name,'research'=>$hasResearchName,'nbarr'=>$nbarr,'graph'=>json_encode($graph)]);
    }

}
