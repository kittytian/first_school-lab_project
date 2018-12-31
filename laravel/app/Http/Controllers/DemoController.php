<?php

namespace App\Http\Controllers;

//require_once '../vendor/autoload.php';

use Illuminate\Http\Request;
use GraphAware\Neo4j\Client\ClientBuilder;

class DemoController extends Controller
{
    public function teachers(Request $request)
    {
        if(!$request->has('name'))
        {
            dd('请输入教师名');
        }
        $names=$request->input('name');
        // dd($arr_names);
        $client = ClientBuilder::create()
            ->addConnection('bolt', 'bolt://neo4j:12345678@10.3.55.50:7687')
            ->build();
        if ($request->has('tnumber'))
        {
            $nums = $request->input('tnumber');
            $queryStrs = explode(";",$nums);
            $queryType = "num";
            $arrNum = $queryStrs;
        }
        else
        {
            $queryStrs = explode(" ",$names);
            $queryType = "name";
            $arrNum = array();
        }
        
        $graph = array();
        $graph["nodes"] = array();
        $graph["links"] = array();
        $hasname = array();
        $persons = array();
        $num2name = array();
        $name2num = array();
        // add teacher node
        foreach($queryStrs as $qs) {
            if($queryType=='num')
                $query1 = "match (t:Teacher{teacher_id:'{$qs}'}) return t";
            else
                $query1 = "match (t:Teacher{name:'{$qs}'}) return t";
            $result1 = $client->run($query1);
            foreach ($result1->getRecords() as $record1) {
                $record1 = (array)$record1;
                $value = (array)$record1["\0*\0values"][0];
                $teacher = array();
                // $teacher["value"] = array();
                foreach($value["\0*\0properties"] as $x=>$x_value) {
                    $teacher[$x] = $x_value;
                    // $teacher["value"][$x] = $x_value;
                }
                // if($queryType=='name')
                //     array_push($arrNum, $teacher["teacher_id"]);
                if(in_array($teacher["name"],$hasname)==False){
                    $teacher["value"] = array();
                    if(isset($teacher["professional_title"]))
                        array_push($teacher["value"], $teacher["professional_title"]);
                    if(isset($teacher["status"]))
                        array_push($teacher["value"], $teacher["status"]);
                    if(isset($teacher["department"]))
                        array_push($teacher["value"], $teacher["department"]);
                    if(isset($teacher["centre"]))
                        array_push($teacher["value"], $teacher["centre"]);
                    if(isset($teacher["team"]))
                        array_push($teacher["value"], $teacher["team"]);
                
                    $teacher["symbolSize"] = 30;
                    $teacher["category"] = "教师搜索词";
                    $teacher["tooltip"] = array();
                    $teacher["tooltip"]["formatter"] = '{b0}:{c0}';
                    array_push($hasname, $teacher["name"]);
                    array_push($graph["nodes"], $teacher);
                    array_push($persons, $teacher["name"]);
                    $num2name[$teacher["teacher_id"]] = $teacher["name"];
                    if($queryType=='name')
                        array_push($arrNum, $teacher["teacher_id"]);
                }
            }
        }
        $nbCootor = array();
        foreach($arrNum as $tn) {
            $hascootor = array();
            $nbCootor[$num2name[$tn]] = 0;
            $query3 = "match (t1:Teacher{teacher_id:'{$tn}'})-[r1]->(c:Course)<-[r2]-(t2:Teacher) return distinct c,t2";
            $result3 = $client->run($query3);
            foreach ($result3->getRecords() as $record3) {
                $record3 = (array)$record3;
                $coursevalue = (array)$record3["\0*\0values"][0];
                $cootorvalue = (array)$record3["\0*\0values"][1];
                $course = array();
                foreach($coursevalue["\0*\0properties"] as $x=>$x_value) {
                    $course[$x] = $x_value;
                }
                /*
                if(in_array($course["name"],$hasname)==False){
                    $course["value"] = array();
                    if(isset($course["faculty"]))
                        array_push($course["value"], $course["faculty"]);
                    if(isset($course["major"]))
                        array_push($course["value"], $course["major"]);
                    $course["symbolSize"] = 10;
                    $course["category"] = "course";
                    $course["tooltip"] = array();
                    $course["tooltip"]["formatter"] = '{b0}:{c0}';
                    array_push($hasname, $course["name"]);
                    array_push($graph["nodes"], $course);
                } */
                $teacher = array();
                foreach($cootorvalue["\0*\0properties"] as $x=>$x_value) {
                    $teacher[$x] = $x_value;
                }    
                if(in_array($teacher["name"],$hasname)==False){
                    $teacher["value"] = array();
                    array_push($teacher["value"], "相同授课");
                    array_push($teacher["value"], $course["name"]);
                    /* if(isset($teacher["professional_title"]))
                        array_push($teacher["value"], $teacher["professional_title"]);
                    if(isset($teacher["status"]))
                        array_push($teacher["value"], $teacher["status"]);
                    if(isset($teacher["department"]))
                        array_push($teacher["value"], $teacher["department"]);
                    if(isset($teacher["centre"]))
                        array_push($teacher["value"], $teacher["centre"]);
                    if(isset($teacher["team"]))
                        array_push($teacher["value"], $teacher["team"]);
                     */
                    $teacher["symbolSize"] = 7;
                    $teacher["category"] = $num2name[$tn]."合作教师";
                    $teacher["tooltip"] = array();
                    $teacher["tooltip"]["formatter"] = '{b0}:{c0}';
                    array_push($hasname, $teacher["name"]);
                    array_push($graph["nodes"], $teacher);
                }
                if(in_array($teacher["name"],$hascootor)==False){
                    $nbCootor[$num2name[$tn]]++;
                    array_push($hascootor,$teacher["name"]);
                }
                $link1 = array();
                $link1["source"] = $num2name[$tn];
                $link1["target"] = $teacher["name"];
                array_push($graph["links"], $link1);
                /* $link2 = array();
                $link2["source"] = $teacher["name"];
                $link2["target"] = $course["name"];
                array_push($graph["links"], $link2);
                 */
            }
            $query4 = "match (t1:Teacher{teacher_id:'{$tn}'})-[r1]->(p:Publication)<-[r2]-(t2:Teacher) where p.publication_type='会议论文' or p.publication_type='期刊论文' or p.publication='学位论文' or p.publication_type='图书专著' or p.publication_type='专利文献' return distinct p,t2";
            $result4 = $client->run($query4);
            foreach($result4->getRecords() as $record4) {
                $record4 = (array)$record4;
                $publicatevalue = (array)$record4["\0*\0values"][0];
                $publication = array();
                foreach($publicatevalue["\0*\0properties"] as $x=>$x_value) {
                    $publication[$x] = $x_value;                    
                }
                if($publication["publication_type"]=="会议论文" or $publication["publication_type"]=="期刊论文" or $publication["publication_type"]=="学位论文") 
                    $publication["category"] = "paper";
                else
                    $publication["category"] = "patent";
                /* if(in_array($publication["title"], $hasname)==False) {
                    $publication["value"] = array();
                    array_push($publication["value"], $publication["publication_type"]);
                    if(isset($publication["publication_date"]))
                        array_push($publication["value"], $publication["publication_type"]);
                    $publication["name"] = $publication["title"];
                    $publication["symbolSize"] = 10;
                    $publication["category"] = "paper";
                    $publication["tooltip"] = array();
                    $publication["tooltip"]["formatter"] = '{b0}:{c0}';
                    array_push($hasname, $publication["name"]);
                    array_push($graph["nodes"], $publication);
                    } */
                $cootorvalue = (array)$record4["\0*\0values"][1];
                $teacher = array();
                foreach($cootorvalue["\0*\0properties"] as $x=>$x_value) {
                    $teacher[$x] = $x_value;
                }
                if(in_array($teacher["name"], $hasname)==False) {
                    $teacher["value"] = array();
                    if($publication["publication_type"]=="会议论文" or $publication["publication_type"]=="期刊论文" or $publication["publication_type"]=="学位论文")
                        array_push($teacher["value"], "论文合作");
                    else
                        array_push($teacher["value"], "专著专利合作");
                    array_push($teacher["value"], $publication["title"]);
                    /* if(isset($teacher["professional_title"]))
                        array_push($teacher["value"], $teacher["professional_title"]);
                    if(isset($teacher["status"]))
                        array_push($teacher["value"], $teacher["status"]);
                    if(isset($teacher["department"]))
                        array_push($teacher["value"], $teacher["department"]);
                    if(isset($teacher["centre"]))
                        array_push($teacher["value"], $teacher["centre"]);
                    if(isset($teacher["team"]))
                        array_push($teacher["value"], $teacher["team"]);
                     */
                    $teacher["symbolSize"] = 7;
                    $teacher["category"] = $num2name[$tn]."合作教师";
                    $teacher["tooltip"] = array();
                    $teacher["tooltip"]["formatter"] = '{b0}:{c0}';
                    array_push($hasname, $teacher["name"]);
                    array_push($graph["nodes"], $teacher);
                }
                if(in_array($teacher["name"],$hascootor)==False) {
                    $nbCootor[$num2name[$tn]]++;
                    array_push($hascootor, $teacher["name"]);                 
                }
                $link1 = array();
                $link1["source"] = $num2name[$tn];
                $link1["target"] = $teacher["name"];
                array_push($graph["links"], $link1);
                /* $link2 = array();
                $link2["source"] = $teacher["name"];
                $link2["target"] = $publication["title"];
                array_push($graph["links"], $link2);
                 */
            }


        }
        // count
        $nbpaper = 0;
        $nbcourse = 0;
        $nbpatent = 0;
        $hastitle = array();
        foreach($arrNum as $i=>$tn1) {
            foreach($arrNum as $j=>$tn2) {
                if($i<$j) {
                    $query2 = "match (t1:Teacher{teacher_id:'{$tn1}'})-[r1]->(p:Publication)<-[r2]-(t2:Teacher{teacher_id:'{$tn2}'}) where (p.publication_type='会议论文') or (p.publication_type='期刊论文') or (p.publication_type='学位论文') return distinct p";
                    $result2 = $client->run($query2);
                    foreach($result2->getRecords() as $record2) {
                        $record2 = (array)$record2;
                        $value = (array)$record2["\0*\0values"][0];
                        $publication = array();
                        foreach($value["\0*\0properties"] as $x=>$x_value) {
                            $publication[$x] = $x_value;                        
                        }
                        if(in_array($publication["title"],$hastitle)==False) {
                            $publication["value"] = array();
                            if(isset($publication["publication_type"]))
                                array_push($publication["value"], $publication["publication_type"]);
                            if(isset($publication["publication_date"]))
                                array_push($publication["value"], $publication["publication_date"]);
                            // if(isset($publication["keywords"]))
                            //     array_push($publication["value"], $publication["keywords"]);
                            $publication["name"] = $publication["title"];
                            $publication["symbolSize"] = 20;
                            $publication["category"] = "论文";
                            $publication["tooltip"] = array();
                            $publication["tooltip"]["formatter"] = '{b0}:{c0}';
                            array_push($hastitle, $publication["name"]);
                            array_push($graph["nodes"], $publication);
                            $nbpaper++;
                        }
                        $link1 = array();
                        $link1["source"] = $num2name[$tn1];
                        $link1["target"] = $publication["title"];
                        array_push($graph["links"], $link1);
                        $link2 = array();
                        $link2["source"] = $num2name[$tn2];
                        $link2["target"] = $publication["title"];
                        array_push($graph["links"], $link2);

                    }
                    //   course
                    $query3 = "match (t1:Teacher{teacher_id:'{$tn1}'})-[r1]->(c:Course)<-[r2]-(t2:Teacher{teacher_id:'{$tn2}'}) return distinct c";
                    $result3 = $client->run($query3);
                    foreach($result3->getRecords() as $record3) {
                        $record3 = (array)$record3;
                        $value = (array)$record3["\0*\0values"][0];
                        $course = array();
                        foreach($value["\0*\0properties"] as $x=>$x_value) {
                            $course[$x] = $x_value;
                        }
                        if(in_array($course["name"],$hastitle)==False) {
                            $course["value"] = array();
                            if(isset($course["faculty"]))
                                array_push($course["value"], $course["faculty"]);
                            if(isset($course["major"]))
                                array_push($course["value"], $course["major"]);
                            $course["symbolSize"] = 20;
                            $course["category"] = "课程";
                            $course["tooltip"] = array();
                            $course["tooltip"]["formatter"] = '{b0}:{c0}';
                            array_push($hastitle, $course["name"]);
                            array_push($graph["nodes"], $course);
                            $nbcourse++;
                        }
                        $link1 = array();
                        $link1["source"] = $num2name[$tn1];
                        $link1["target"] = $course["name"];
                        array_push($graph["links"], $link1);
                        $link2 = array();
                        $link2["source"] = $num2name[$tn2];
                        $link2["target"] = $course["name"];
                        array_push($graph["links"], $link2);
                    }
                    // patent
                    $query4 = "match (t1:Teacher{teacher_id:'{$tn1}'})-[r1]->(p:Publication)<-[r2]-(t2:Teacher{teacher_id:'{$tn2}'}) where (p.publication_type='图书专著') or (p.publication_type='专利文献') return distinct p";
                    $result4 = $client->run($query4);
                    foreach($result4->getRecords() as $record4) {
                        $record4 = (array)$record4;
                        $value = (array)$record4["\0*\0values"][0];
                        $publication = array();
                        foreach($value["\0*\0properties"] as $x=>$x_value) {
                            $publication[$x] = $x_value;
                        }
                        if(in_array($publication["title"],$hastitle)==False) {
                            $publication["value"] = array();
                            if(isset($publication["publication_type"]))
                                array_push($publication["value"], $publication["publication_type"]);
                            if(isset($publication["publication_date"]))
                                array_push($publication["value"], $publication["publication_date"]);
                            $publication["name"] = $publication["title"];
                            $publication["symbolSize"] = 20;
                            $publication["category"] = "专著专利";
                            $publication["tooltip"] = array();
                            $publication["tooltip"]["formatter"] = '{b0}:{c0}';
                            array_push($hastitle, $publication["name"]);
                            array_push($graph["nodes"], $publication);
                            $nbpatent++;
                        }
                        $link1 = array();
                        $link1["source"] = $num2name[$tn1];
                        $link1["target"] = $publication["title"];
                        array_push($graph["links"], $link1);
                        $link2 = array();
                        $link2["source"] = $num2name[$tn2];
                        $link2["target"] = $publication["title"];
                        array_push($graph["links"], $link2);
                    }

                }
            }
        }
        $nbarr = array();
        $nbarr['paper'] = $nbpaper;
        $nbarr["course"] = $nbcourse;
        $nbarr["patent"] = $nbpatent;    
        $view = 'demo.teachers';
        // dd($graph);
        //return view($view)->with(['graph'=>json_encode($graph), 'nbarr'=>json_encode($nbarr), 'nbCotor'=>json_encode($nbCootor), 'persons'=>json_encode($persons)]);
        return view($view)->with(['graph'=>json_encode($graph), 'nbarr'=>$nbarr, 'nbCootor'=>$nbCootor, 'persons'=>$persons, 'persons_json'=>json_encode($persons)]);
        //return view($view)->with(['graph'=>json_encode($graph), 'nbarr'=>$nbarr, 'nbCotor'=>$nbCootor, 'persons'=>$persons]);

    }


    public function index(Request $request) 
    {
        if(!$request->has('name'))
        {
            dd('no name');
        }
        $type=0;
        $request->has('type')?$type=$request->input('type'):0;
        $name=$request->input('name');

        $client = ClientBuilder::create()
            ->addConnection('bolt', 'bolt://neo4j:12345678@10.3.55.50:7687')
            ->build();
        $query1 = "MATCH (n:Teacher{name:'{$name}'}) RETURN n";
        $result1 = $client->run($query1);
        //properties of the teacher        
        $teachers = array();
        foreach ($result1->getRecords() as $record) {
            $record = (array)$record;
            $value = (array)$record["\0*\0values"][0];
            $teacher = array('');
            foreach($value["\0*\0properties"] as $x=>$x_value) {
                $teacher[$x] = $x_value;
            }
            array_push($teachers, $teacher);
        }
        //dd($teacher);
        $graph = array();
        $graph["nodes"] = array();
        $graph["links"] = array();
        $node = array();
        $node["name"] = $name;
        $node["value"] = array();
        if(isset($teacher["professional_title"]))
                        array_push($node["value"], $teacher["professional_title"]);
        if(isset($teacher["status"]))
                        array_push($node["value"], $teacher["status"]);
        if(isset($teacher["department"]))
                        array_push($node["value"], $teacher["department"]);
        if(isset($teacher["centre"]))
                        array_push($node["value"], $teacher["centre"]);
        if(isset($teacher["team"]))
                        array_push($node["value"], $teacher["team"]);
                //dd($node);
        $node["category"] = "Teacher";
        $node["symbolSize"] = 20;
        $node["tooltip"] = array();
        $node["tooltip"]["formatter"] = '{b0}:{c0}';
        array_push($graph["nodes"], $node);
        $hasname = array(); 

        $hasname2=array();

        //cooperators of the teacher on courses(课程)
        $query2 = "MATCH (t1:Teacher{name:'{$name}'})-[r1]->(c:Course)<-[r2]-(t2:Teacher) WHERE NOT (t2.name=t1.name) RETURN DISTINCT t2,c";
        $result2 = $client->run($query2);
        // $record2 = $result2->getRecords();
      //  dd($record2);
        // $graph = $record2["graph"];
        // $courseCootors = array();
        foreach ($result2->getRecords() as $record2) {
            $record2 = (array)$record2;
            // $coursevalue = (array)$record2["\0*\0values"][0];
            $teachervalue2 = (array)$record2["\0*\0values"][0];
            $coursevalue = (array)$record2["\0*\0values"][1];

            $teacher = array('');
            $course =array('');

            foreach($teachervalue2["\0*\0properties"] as $x=>$x_value) {
                $teacher[$x] = $x_value;
            }
             foreach($coursevalue["\0*\0properties"] as $x=>$x_value) {
                $course[$x] = $x_value;
            }

            $node = array();

            if(in_array($teacher["name"],$hasname)==False){
            $node["name"] = $teacher["name"];
            $node["category"] = "courseCootor";
            $node["symbolSize"] = 20;
            array_push($hasname, $teacher["name"]);
            array_push($graph["nodes"], $node);
            }

            $node2 = array();
            if (in_array($course["name"],$hasname2)==False) {
            $node2["value"] = array();
             if(isset($course["faculty"]))
                                array_push($node2["value"], $course["faculty"]);
            if(isset($course["major"]))
                                array_push($node2["value"], $course["major"]);
            $node2["name"] = $course["name"];
            $node2["category"] = "course";
            $node2["symbolSize"] = 10;
            $node2["tooltip"] = array();
            $node2["tooltip"]["formatter"] = '{b0}:{c0}';
            array_push($hasname2, $course["name"]);
            array_push($graph["nodes"], $node2);
        }
            
            



            $link = array();
            $link["source"] = $name;
            $link["target"] = $course["name"];
            //$link["target"] = $teacher["name"];
            //
            array_push($graph["links"], $link); 
            
            $link2 = array();
            $link2["source"] = $link["target"]; 
            //$link2["target"] = $course["name"];
            $link2["target"] = $teacher["name"];
            array_push($graph["links"], $link2);

        } 
        $hasname1= array(); 
        //cooperators of the teacher on papers(论文)
        $query3 = "MATCH (t1:Teacher{name:'{$name}'})-[r1]->(p:Publication)<-[r2]-(t2:Teacher) WHERE NOT (t2.name=t1.name) AND (p.publication_type='期刊论文' or (p.publication_type='会议论文') or (p.publication_type='学位论文')) RETURN DISTINCT t2,p";
        $result3 = $client->run($query3);
        foreach ($result3->getRecords() as $record3) {
            $record3 = (array)$record3;
            
            $teachervalue3 = (array)$record3["\0*\0values"][0];
            $publicationvalue= (array)$record3["\0*\0values"][1];
            $teacher = array('');
            $publication = array('');
            
            
            foreach($teachervalue3["\0*\0properties"] as $x=>$x_value) {
                $teacher[$x] = $x_value;
            }

            foreach($publicationvalue["\0*\0properties"] as $x=>$x_value) {
                                  $publication[$x] = $x_value;
                               }     



            $node = array();
            if (in_array($teacher["name"],$hasname)==False) {
                $node["name"] = $teacher["name"];
                $node["category"] = "paperCootor";
                $node["symbolSize"] = 20;
                array_push($graph["nodes"], $node);
                array_push($hasname, $teacher["name"]);    
                //array_push($hasname1, $publication["title"]);

            }    
            //dd($hasname1);

            $node1 = array();
            //array_push($hasname1, $publication["title"]);
            //dd($hasname1);
            if (in_array($publication["title"],$hasname1)==False) {
                $node1["name"] = $publication["title"];
                $node1["category"] = "paper";
                $node1["value"] = array();
                if(isset($publication["publication_type"]))
                                array_push($node1["value"], $publication["publication_type"]);
                if(isset($publication["publication_date"]))
                                array_push($node1["value"], $publication["publication_date"]);

                $node1["symbolSize"] = 10;
                $node1["tooltip"] = array();
                $node1["tooltip"]["formatter"] = '{b0}:{c0}';
                array_push($graph["nodes"], $node1);
               //dd($node1);
                array_push($hasname1, $publication["title"]);    
            }    
           //dd($node1);

            $link = array();
            $link["source"] = $name;
            $link["target"] = $publication["title"];
            //$link["target"] = $teacher["name"];
            //$link["source"] = $teacher["name"];
            //$link["target"] = $publication["title"];
            array_push($graph["links"], $link);

            $link1 = array();
            $link1["source"] = $link["target"]; 
            $link1["target"] = $teacher["name"];
            array_push($graph["links"], $link1);

         // dd($publication);
          //  dd($link1);
           // dd($node1);
           // dd($graph["nodes"]);
        // dd($graph["links"]);


        }
    
         
    //cooperators of the teacher on papers(专著专利)
        $query4 = "match (t1:Teacher{name:'{$name}'})-[r1]->(p:Publication)<-[r2]-(t2:Teacher) where not (t2.name=t1.name) and (p.publication_type='图书专著' or (p.publication_type='专利文献')) return distinct t2,p";
        $result4 = $client->run($query4);
        foreach ($result4->getRecords() as $record4) {
            $record4 = (array)$record4;
            // $patentvalue = (array)$record4["\0*\0values"][0];
            $teachervalue4 = (array)$record4["\0*\0values"][0];
            $publicationvalue1=(array)$record4["\0*\0values"][1];
            $teacher = array('');
            $publication = array('');
            foreach($teachervalue4["\0*\0properties"] as $x=>$x_value) {
                $teacher[$x] = $x_value;
            }
             foreach($publicationvalue1["\0*\0properties"] as $x=>$x_value) {
                $publication[$x] = $x_value;
            }


            $node = array();
            if (in_array($teacher["name"],$hasname)==False) {
                $node["name"] = $teacher["name"];
                $node["category"] = "patentCootor";
                $node["symbolSize"] = 20;
                array_push($graph["nodes"], $node);
                array_push($hasname, $teacher["name"]);
            }    
            
            

            $node1 = array();
            if (in_array($publication["title"],$hasname1)==False) {
                $node1["name"] = $publication["title"];
                $node1["category"] = "patent";
                $node1["symbolSize"] = 10;
                $node1["value"] = array();
                if(isset($publication["publication_type"]))
                                array_push($node1["value"], $publication["publication_type"]);
                if(isset($publication["publication_date"]))
                                array_push($node1["value"], $publication["publication_date"]);

                
                $node1["tooltip"] = array();
                $node1["tooltip"]["formatter"] = '{b0}:{c0}';
                array_push($graph["nodes"], $node1);
                array_push($hasname1, $publication["title"]);
            }    


            $link = array();
            $link["source"] = $name;
            $link["target"] = $publication["title"];
            /*
            $patentCootor["patent"] = array('');
            foreach($patentvalue["\0*\0properties"] as $y=>$y_value) {
                $patentCootor["patent"][$y] = $y_value;
            } */
            array_push($graph["links"], $link);
            
            $link1 = array();
            $link1["source"] = $link["target"]; 
            $link1["target"] = $teacher["name"];
            array_push($graph["links"], $link1);



        }
        // dd($patentCootors);       
         //dd($graph); 
        /*$test=array();
        $xAxis=["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"];
        $count=[5, 20, 36, 10, 10, 20];
        $test['x']=$xAxis;
        $test['count']=$count;*/
        // return view('echart')->with('test',json_encode($test)); 

        /*
        $view=null;
        switch($type)
        {
        case 0:
            $view='demo.detail';
            return view($view)->with(['name'=>$name,'type'=>$type,'teachers'=>$teachers]);
        case 1:
            $view='demo.detail1';
            return view($view)->with(['name'=>$name,'type'=>$type,'graph'=>json_encode($graph)]);
            // return view($view)->with(['name'=>$name,'type'=>$type,'paperCootors'=>$paperCootors,'courseCootors'=>$courseCootors,'patentCootors'=>$patentCootors]);       
        case 2:
            $view='demo.detail2';
            return view($view)->with(['name'=>$name,'type'=>$type,'teachers'=>$teachers]);
        case 3:
            $view='demo.detail3';
            return view($view)->with(['name'=>$name,'type'=>$type,'teachers'=>json_encode($teachers)]);
        default:dd('error');
        }
*/
        return view('demo.final')->with(['name'=>$name,'type'=>$type,'teachers'=>$teachers,'graph'=>json_encode($graph),'teacherss'=>json_encode($teachers)]);
    }    


    /*
     * echart demo
     *
     * */
    /*public function echart()
    {
        $test=array();
        $xAxis=["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"];
        $count=[5, 20, 36, 10, 10, 20];
        $test['x']=$xAxis;
        $test['count']=$count;
        return view('echart')->with('test',json_encode($test));

    } */

    public function rdetail(Request $request)
    {
        return view('demo.researchDetail');
    }
}
