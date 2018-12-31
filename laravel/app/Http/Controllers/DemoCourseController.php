<?php

namespace App\Http\Controllers;

//require_once '../vendor/autoload.php';

use Illuminate\Http\Request;
use GraphAware\Neo4j\Client\ClientBuilder;

class DemoCourseController extends Controller
{

    public function index(Request $request) 
    {
        if(!$request->has('name'))
        {
            dd('no name');
        }
        $name=$request->input('name');

        $client = ClientBuilder::create()
            ->addConnection('bolt', 'bolt://neo4j:12345678@10.3.55.50:7687')
            ->build();
        $query = "match (n:Course)<-[r]-(t:Teacher) where n.name=~'.*(?i)" . "{$name}"  . ".*' return distinct n,t";
        $result = $client->run($query);
		
        $graph = array();
        $graph["nodes"] = array();
        $graph["links"] = array();
        $hasCourseName = array();
        $hasTeacherName = array();
        $nbcourse = 0;
        $nbteacher = 0;
        // $hasOthercName = array();
        foreach ($result->getRecords() as $record) {
            $record = (array)$record;
            $value_course = (array)$record["\0*\0values"][0];
            $course = array('');
            foreach($value_course["\0*\0properties"] as $x=>$x_value) {
                $course[$x] = $x_value;
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
            if(in_array($course["name"], $hasCourseName) == False) {
                $node["name"] = $course["name"];
                $node["category"] = "课程";
                $node["symbolSize"] = 30;
                $node["tooltip"] = array();
                $node["tooltip"]["formatter"] = '{b0}:{c0}';
                $node["value"] = array();
                if(isset($course["faculty"]))
                    array_push($node["value"], $course["faculty"]);
                if(isset($course["major"]))
                    array_push($node["value"], $course["major"]);
                array_push($graph["nodes"], $node);
                array_push($hasCourseName, $course["name"]);
                $nbcourse++;
            }
            $node = array();
            if(in_array($teacher["name"], $hasTeacherName) == False) {
                $node["name"] = $teacher["name"];
                $node["category"] = "授课教师";
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
            }
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
            $link["target"] = $course["name"];
            if(in_array($link, $graph["links"])==False)
                array_push($graph["links"], $link);
            /* $link2 = array();
            $link2["source"] = $course["name"];
            $link2["target"] = $otherc["name"];
            if(in_array($link2, $graph["links"])==False)
                array_push($graph["links"], $link2);
             */
        }
        $nbpre = 0;
        $nbnex = 0;
        foreach ($hasCourseName as $cname) {
            $query1 = "match (nc:Course)-[r1]->(c:Course{name:'{$cname}'}) return distinct nc";
            $result1 = $client->run($query1);
            foreach($result1->getRecords() as $record1) {
                $record1 = (array)$record1;
                $value = $record1["\0*\0values"];
                $preornex = "nex";
                foreach($value as $value_course) {
                    $value_course = (array)$value_course;
                    $course = array();
                    foreach($value_course["\0*\0properties"] as $x=>$x_value) {
                        $course[$x] = $x_value;
                    }
                    if(isset($course["name"]) and in_array($course["name"],$hasCourseName)==False) {
                        $course["value"] = array();
                        if(isset($course["department"]))
                            array_push($course["value"], $course["department"]);
                        if(isset($course["major"]))
                            array_push($course["value"], $course["major"]);
                        $course["symbolSize"] = 30;
                        
                        // if($preornex=="pre"){
                        $course["category"] = "后续课程";
                        $nbnex++;
                        // }
                        // else {
                        //     $course["category"] = "后续课程";
                        //     $nbnex++;
                        // }
                        $course["tooltip"] = array();
                        $course["tooltip"]["formatter"] = '{b0}:{c0}';
                        array_push($hasCourseName, $course["name"]);
                        array_push($graph["nodes"], $course);
                    }
                    $link = array();
                    if($preornex=="nex") {
                        $course["category"] = "后续课程";
                        $link["source"] = $cname;
                        $link["target"] = $course["name"];
                        //$nbnex++;
                        // $preornex = "nex";
                    }
                    else{
                        $course["category"] = "先修课程";
                        $link["source"] = $course["name"];
                        $link["target"] = $cname;
                        // $preornex = "nex";
                        //$nbpre++;
                    }
                    if(in_array($link, $graph["links"])==False)
                        array_push($graph["links"], $link);
                    
                }
            }
            $query2 = "match (pc:Course)<-[r1]-(c:Course{name:'{$cname}'}) return distinct pc";
            $result2 = $client->run($query2);
            foreach($result2->getRecords() as $record2) {
                $record2 = (array)$record2;
                // if(isset($record2["\0*\0values"]))
                $value = $record2["\0*\0values"];
                $value_course = (array)$value[0];
                $course = array();
                foreach($value_course["\0*\0properties"] as $x=>$x_value) {
                    $course[$x] = $x_value;
                }
                if(isset($course["name"]) and in_array($course["name"],$hasCourseName)==False) {
                    $course["value"] = array();
                    if(isset($course["department"]))
                        array_push($course["value"], $course["department"]);
                    if(isset($course["major"]))
                        array_push($course["value"], $course["major"]);
                    $course["symbolSize"] = 30;
                    $course["category"] = "先修课程";
                    $nbpre++;
                    $course["tooltip"] = array();
                    $course["tooltip"]["formatter"] = '{b0}:{c0}';
                    array_push($hasCourseName, $course["name"]);
                    array_push($graph["nodes"], $course);
                }
                $link = array();
                // $course["category"] = "后续课程";
                $link["source"] = $course["name"];
                $link["target"] = $cname;
                if(in_array($link, $graph["links"])==False)
                    array_push($graph["links"], $link);
            }
        }
        $nbarr = array();
        $nbarr["course"] = $nbcourse;
        $nbarr["teacher"] = $nbteacher;
        $nbarr["pre"] = $nbpre;
        $nbarr["nex"] = $nbnex;
        // dd($graph);
        $view = 'democourse';
        return view($view)->with(['name'=>$name,'nbarr'=>$nbarr,'graph'=>json_encode($graph)]);
    }

}
