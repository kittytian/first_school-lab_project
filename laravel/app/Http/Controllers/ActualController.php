<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GraphAware\Neo4j\Client\ClientBuilder;

class ActualController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->has('name'))
        {
            dd('请输入教师名');
        }
        // if(!$request->has('tnumber'))
        // {
        //    dd('no tnumber');
        // }
        $type=0;
        $request->has('type')?$type=$request->input('type'):0;
        $name=$request->input('name');
        // $tnumber=$request->input('tnumber');
        $client = ClientBuilder::create()
            ->addConnection('bolt', 'bolt://neo4j:12345678@10.3.55.50:7687')
            ->build();
        if (!$request->has('tnumber'))
            $query1 = "MATCH (n:Teacher{name:'{$name}'}) RETURN n";
        else
        {
            $tnumber=$request->input('tnumber');
            $query1 = "MATCH (n:Teacher{teacher_id:'{$tnumber}'}) RETURN n";
        }    
        $result1 = $client->run($query1);
        //properties of the teacher        
        $teachers = array();
        $hasTeacherName = array();
        foreach ($result1->getRecords() as $record) {
            $record = (array)$record;
            $value = (array)$record["\0*\0values"][0];
            $teacher = array('');
            foreach($value["\0*\0properties"] as $x=>$x_value) {
                $teacher[$x] = $x_value;
            }
            if(in_array($teacher["name"], $hasTeacherName)==False){
                array_push($teachers, $teacher);
                array_push($hasTeacherName, $teacher["name"]);
                $tnumber = $teacher["teacher_id"];
            }
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
        $node["category"] = "中心教师";
        $node["symbolSize"] = 20;
        $node["tooltip"] = array();
        $node["tooltip"]["formatter"] = '{b0}:{c0}';
        array_push($graph["nodes"], $node);




        $hasProjectName= array(); 
        $ProjectDateCount = array_fill(0,25,0);
        $queryproject = "MATCH (t1:Teacher{teacher_id:'{$tnumber}'})-[r1]->(p:Project) RETURN DISTINCT p";
        $queryresult1 = $client->run($queryproject);
        foreach ($queryresult1->getRecords() as $queryresult) {
            $queryresult = (array)$queryresult;
            
            $projectvalue = (array)$queryresult["\0*\0values"][0];
            
            
            $project = array('');

            foreach($projectvalue["\0*\0properties"] as $x=>$x_value) {
                                  $project[$x] = $x_value;
                               }     

            $node1 = array();
           
            if (in_array($project["name"],$hasProjectName)==False) {
                $node1["name"] = $project["name"];
                $node1["category"] = "项目";
                $node1["value"] = array();
                if(isset($project["department"]))
                    array_push($node1["value"], $project["department"]);
                if(isset($project["date_setup"])) {
                    array_push($node1["value"], "立项日期：".$project["date_setup"]);
                    $ProjectDateCount[intval(substr($project["date_setup"],0,4))-1995]++;
                
                }
                }
                $node1["symbolSize"] = 10;
                $node1["tooltip"] = array();
                $node1["tooltip"]["formatter"] = '{b0}:{c0}';
                array_push($graph["nodes"], $node1);
               
                array_push($hasProjectName, $project["name"]);    
                
           

            $link = array();
            $link["source"] = $name;
            $link["target"] = $project["name"];
            array_push($graph["links"], $link);

         


        }

//        dd($graph);


        $hasCootorName = array(); 
        $hasCourseName =array();
        //cooperators of the teacher on courses(课程)
        $query2 = "MATCH (t1:Teacher{teacher_id:'{$tnumber}'})-[r1]->(c:Course)<-[r2]-(t2:Teacher) WHERE NOT (t2.name=t1.name) RETURN DISTINCT t2,c";
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

            if(in_array($teacher["name"],$hasCootorName)==False){
            $node["name"] = $teacher["name"];
            $node["category"] = "课程合作教师";
            $node["symbolSize"] = 20;
            array_push($hasCootorName, $teacher["name"]);
            array_push($graph["nodes"], $node);
            }

            $node2 = array();
            if (in_array($course["name"],$hasCourseName)==False) {
            $node2["value"] = array();
             if(isset($course["faculty"]))
                                array_push($node2["value"], $course["faculty"]);
            if(isset($course["major"]))
                                array_push($node2["value"], $course["major"]);
            $node2["name"] = $course["name"];
            $node2["category"] = "课程";
            $node2["symbolSize"] = 10;
            $node2["tooltip"] = array();
            $node2["tooltip"]["formatter"] = '{b0}:{c0}';
            array_push($hasCourseName, $course["name"]);
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
        $hasPaperName= array(); 
        $PaperDateCount = array_fill(0,25,0);
        //cooperators of the teacher on papers(论文)
        $query3 = "MATCH (t1:Teacher{teacher_id:'{$tnumber}'})-[r1]->(p:Publication)<-[r2]-(t2:Teacher) WHERE NOT (t2.name=t1.name) AND (p.publication_type='期刊论文' or (p.publication_type='会议论文') or (p.publication_type='学位论文')) RETURN DISTINCT t2,p";
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
            if (in_array($teacher["name"],$hasCootorName)==False) {
                $node["name"] = $teacher["name"];
                $node["category"] = "论文合作教师";
                $node["symbolSize"] = 20;
                array_push($graph["nodes"], $node);
                array_push($hasCootorName, $teacher["name"]);    
                //array_push($hasname1, $publication["title"]);

            }    
            //dd($hasname1);

            $node1 = array();
            //array_push($hasname1, $publication["title"]);
            //dd($hasname1);
            if (in_array($publication["title"],$hasPaperName)==False) {
                $node1["name"] = $publication["title"];
                $node1["category"] = "论文";
                $node1["value"] = array();
                if(isset($publication["publication_type"]))
                    array_push($node1["value"], $publication["publication_type"]);
                if(isset($publication["publication_date"])) {
                    // intval($publication["publication_date"]);
                    $PaperDateCount[intval($publication["publication_date"])-1995]++;
                    array_push($node1["value"], $publication["publication_date"]);
                }
                $node1["symbolSize"] = 10;
                $node1["tooltip"] = array();
                $node1["tooltip"]["formatter"] = '{b0}:{c0}';
                array_push($graph["nodes"], $node1);
               //dd($node1);
                array_push($hasPaperName, $publication["title"]);    
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
    
       




        $hasPatentName = array();
        $PatentDateCount = array_fill(0,25,0);
        // dd($PatentDateCount); 
        //cooperators of the teacher on papers(专著专利)
        $query4 = "match (t1:Teacher{teacher_id:'{$tnumber}'})-[r1]->(p:Publication)<-[r2]-(t2:Teacher) where not (t2.name=t1.name) and (p.publication_type='图书专著' or (p.publication_type='专利文献')) return distinct t2,p";
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
            if (in_array($teacher["name"],$hasCootorName)==False) {
                $node["name"] = $teacher["name"];
                $node["category"] = "专著专利合作教师";
                $node["symbolSize"] = 20;
                array_push($graph["nodes"], $node);
                array_push($hasCootorName, $teacher["name"]);
            }    
            
            

            $node1 = array();
            if (in_array($publication["title"],$hasPatentName)==False) {
                $node1["name"] = $publication["title"];
                $node1["category"] = "专著专利";
                $node1["symbolSize"] = 10;
                $node1["value"] = array();
                if(isset($publication["publication_type"]))
                    array_push($node1["value"], $publication["publication_type"]);
                if(isset($publication["publication_date"])) {
                    $PatentDateCount[intval($publication["publication_date"])-1995]++;
                    array_push($node1["value"], $publication["publication_date"]);
                }
                
                $node1["tooltip"] = array();
                $node1["tooltip"]["formatter"] = '{b0}:{c0}';
                array_push($graph["nodes"], $node1);
                array_push($hasPatentName, $publication["title"]);
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

        $DateCount = array();
        array_push($DateCount, $ProjectDateCount);
        array_push($DateCount, $PatentDateCount); 
        array_push($DateCount, $PaperDateCount);
        // dd($DateCount);

        $directions = array();
        $query5 = "match (t:Teacher{teacher_id:'{$tnumber}'})-[r]->(d:ResearchDirection) return distinct d";
        $result5 = $client->run($query5);
        foreach ($result5->getRecords() as $record5) {
            $record5 = (array)$record5;
            $value = (array)$record5["\0*\0values"][0];
            $direction = array();
            foreach($value["\0*\0properties"] as $x=>$x_value) {
                $direction[$x] = $x_value;
            }
            array_push($directions,$direction["content"]);
        }
        // dd($graph);
        





        $cpl=$this->search($request);
        return view('actual.final')->with($cpl+['name'=>$name,'type'=>$type,'teachers'=>$teachers,'directions'=>$directions,'DateCount'=>json_encode($DateCount),'graph'=>json_encode($graph),'teacherss'=>json_encode($teachers)]);
    }

    public function search(Request $request)
    {
        if(!$request->has('name'))
            dd('请输入教师名');
    
        $teacherName = $request->input('name');
        // $tnumber = $request->input('tnumber');
        $client = ClientBuilder::create()
            ->addConnection('bolt', 'bolt://neo4j:12345678@10.3.55.50:7687')
            ->build();
        if ($request->has('tnumber'))
            $tnumber = $request->input('tnumber');
        else
        {
            $query_teacher = "match (n:Teacher{name:'{$teacherName}'}) return n";
            $result_teacher = $client->run($query_teacher);
            $teachers = array();
            $hasTeacherName = array();
            foreach ($result_teacher->getRecords() as $record) {
                $record = (array)$record;
                $value = (array)$record["\0*\0values"][0];
                $teacher = array('');
                foreach($value["\0*\0properties"] as $x=>$x_value) {
                    $teacher[$x] = $x_value;
                }
                if(in_array($teacher["name"], $hasTeacherName)==False){
                    array_push($teachers, $teacher);
                    array_push($hasTeacherName, $teacher["name"]);
                    $tnumber = $teacher["teacher_id"];
                }
            }
        }        
        $query_courses = "match (n:Teacher {teacher_id:'{$tnumber}'})-[r]->(c:Course) return distinct c";
        $result_courses = $client->run($query_courses);
        $courses = array();
        foreach ($result_courses->getRecords() as $record) {
            $record = (array)$record;
            $value = (array)$record["\0*\0values"][0];
            $course = array('');
            foreach($value["\0*\0properties"] as $x=>$x_value) {
                $course[$x] = $x_value;
            }
            array_push($courses, $course);
        }

        $query_papers = "match (t:Teacher{teacher_id:'{$tnumber}'})-[r]->(p:Publication) where p.publication_type='期刊论文' or (p.publication_type='会议论文') or (p.publication_type='学位论文') return distinct p ORDER BY p.publication_date DESC;";
        $result_papers = $client->run($query_papers);
        $papers = array();
        foreach ($result_papers->getRecords() as $record) {
            $record = (array)$record;
            $value = (array)$record["\0*\0values"][0];
            $paper = array('');
            foreach($value["\0*\0properties"] as $x=>$x_value) {
                $x_value=str_replace('\'','',$x_value);$x_value=str_replace('[','',$x_value);$x_value=str_replace(']','',$x_value); 
                $paper[$x] = $x_value;
            }
            array_push($papers, $paper);
        }

        $query_books = "match (t:Teacher{teacher_id:'{$tnumber}'})-[r]->(p:Publication) where p.publication_type='图书专著' or (p.publication_type='专利文献') return distinct p ORDER BY p.publication_date DESC;";
        $result_books = $client->run($query_books);
        $books = array();
        foreach ($result_books->getRecords() as $record) {
            $record = (array)$record;
            $value = (array)$record["\0*\0values"][0];
            $book = array('');
            foreach($value["\0*\0properties"] as $x=>$x_value) {
                $x_value=str_replace('\'','',$x_value);$x_value=str_replace('[','',$x_value);$x_value=str_replace(']','',$x_value);
                $book[$x] = $x_value;
            }
            array_push($books, $book);
        }
		
		$query_project = "match (t:Teacher{teacher_id:'{$tnumber}'})-[r]->(p:Project) return distinct p ORDER BY p.date_setup DESC";
		$result_project = $client->run($query_project);
		$projects = array();
		foreach ($result_project->getRecords() as $record) {
			$record = (array)$record;
			$value = (array)$record["\0*\0values"][0];
			$project = array('');
			foreach($value["\0*\0properties"] as $x=>$x_value) {
				$x_value=str_replace('\'','',$x_value);$x_value=str_replace('[','',$x_value);$x_value=str_replace(']','',$x_value);
				$project[$x] = $x_value;
			}
			array_push($projects, $project);
        }

        $query_years_by_paper = "match (t:Teacher{teacher_id:'{$tnumber}'})-[r]->(p:Publication) where p.publication_type='期刊论文' or (p.publication_type='会议论文') or (p.publication_type='学位论文') return distinct p.publication_date;";
        $result_years_by_paper = $client->run($query_years_by_paper);
        $years_by_paper = array();
        foreach ($result_years_by_paper->getRecords() as $record) {
            $record = (array)$record;
            $value = (array)$record["\0*\0values"];
            foreach($value as $x_value) {
                $year = substr($x_value, 0, 4);
                $num = count($years_by_paper);
				if(in_array($year, $years_by_paper) == False) {
					array_push($years_by_paper, $year);
				}
            }
        }
        rsort($years_by_paper);
        $papers_all_year = array();
        foreach ($years_by_paper as $each_year) {
            $query_papers_each_year = "match (t:Teacher{teacher_id:'{$tnumber}'})-[r]->(p:Publication) where p.publication_date starts with '{$each_year}' and ( p.publication_type='期刊论文' or (p.publication_type='会议论文') or (p.publication_type='学位论文') ) return distinct p ORDER BY p.publication_date DESC;";
            $result_papers_each_year = $client->run($query_papers_each_year);
            $papers_each_year = array();
            foreach ($result_papers_each_year->getRecords() as $record) {
                $record = (array)$record;
                $value = (array)$record["\0*\0values"][0];
                $paper = array('');
                foreach ($value["\0*\0properties"] as $x=>$x_value) {
                    $x_value=str_replace('\'','',$x_value);$x_value=str_replace('[','',$x_value);$x_value=str_replace(']','',$x_value);
                    $paper[$x] = $x_value;
                }
                array_push($papers_each_year, $paper);
            }
            array_push($papers_all_year, $papers_each_year);
        }
        
        $query_years_by_book = "match (t:Teacher{teacher_id:'{$tnumber}'})-[r]->(p:Publication) where p.publication_type='图书专著' or (p.publication_type='专利文献') return distinct p.publication_date;";
        $result_years_by_book = $client->run($query_years_by_book);
        $years_by_book = array();
        foreach ($result_years_by_book->getRecords() as $record) {
            $record = (array)$record;
            $value = (array)$record["\0*\0values"];
            foreach($value as $x_value) {
                $year = substr($x_value, 0, 4);
                $num = count($years_by_book);
				if(in_array($year, $years_by_book) == False) {
					array_push($years_by_book, $year);
				}
            }
        }
        rsort($years_by_book);
        $books_all_year = array();
        foreach ($years_by_book as $each_year) {
            $query_books_each_year = "match (t:Teacher{teacher_id:'{$tnumber}'})-[r]->(p:Publication) where p.publication_date starts with '{$each_year}' and ( p.publication_type='图书专著' or (p.publication_type='专利文献') ) return distinct p ORDER BY p.publication_date DESC;";
            $result_books_each_year = $client->run($query_books_each_year);
            $books_each_year = array();
            foreach ($result_books_each_year->getRecords() as $record) {
                $record = (array)$record;
                $value = (array)$record["\0*\0values"][0];
                $book = array('');
                foreach ($value["\0*\0properties"] as $x=>$x_value) {
                    $x_value=str_replace('\'','',$x_value);$x_value=str_replace('[','',$x_value);$x_value=str_replace(']','',$x_value);
                    $book[$x] = $x_value;
                }
                array_push($books_each_year, $book);
            }
            array_push($books_all_year, $books_each_year);
        }
		
		$query_years_by_project = "match (t:Teacher{teacher_id:'{$tnumber}'})-[r]->(p:Project) return distinct p ORDER BY p.date_setup DESC";
		$result_years_by_project = $client->run($query_years_by_project);
		$years_by_project = array();
        foreach ($result_years_by_project->getRecords() as $record) {
			$record = (array)$record;
			$value = (array)$record["\0*\0values"];
			foreach($value as $node) {
                $node = (array)$node;
                $prop = $node["\0*\0properties"];
                if(isset($prop["date_setup"])) {
                    $year = substr($prop["date_setup"], 0, 4);
				    $num = count($years_by_project);
				    if(in_array($year, $years_by_project) == False) {
					    array_push($years_by_project, $year);
                    
                    }
                }
			}
		}
		rsort($years_by_project);
		$projects_all_year = array();
		foreach ($years_by_project as $each_year) {
			$query_pojects_each_year = "match (t:Teacher{teacher_id:'{$tnumber}'})-[r]->(p:Project) where p.date_setup starts with '{$each_year}' return distinct p ORDER BY p.date_setup DESC";
			$result_projects_each_year = $client->run($query_pojects_each_year);
			$projects_each_year = array();
            foreach ($result_projects_each_year->getRecords() as $record) {
				$record = (array)$record;
				$value = (array)$record["\0*\0values"];
                foreach ($value as $node) {
                    $node = (array)$node;
                    $project = array('');
                    foreach ($node["\0*\0properties"] as $x=>$x_value) {
                        $x_value=str_replace('\'','',$x_value);$x_value=str_replace('[','',$x_value);$x_value=str_replace(']','',$x_value);
                        $project[$x] = $x_value;
                    }
                    array_push($projects_each_year, $project);
                }
			}
			array_push($projects_all_year, $projects_each_year);
		}
     
        //dd($years_by_paper);
        //echo json_encode((object)$json);
        return ['courses'=>$courses, 'papers'=>$papers, 'books'=>$books, 'projects'=>$projects, 'years_by_paper'=>$years_by_paper, 'papers_all_year'=>$papers_all_year, 'years_by_book'=>$years_by_book, 'books_all_year'=>$books_all_year, 'years_by_project'=>$years_by_project, 'projects_all_year'=>$projects_all_year];
    }

    //重名教师搜索
    public function presearch(Request $request)
    {   
        $type=0;
        $request->has('type')?$type=$request->input('type'):0;
        $teacherNames = $request->input('keyword');
        $arrNames = explode(" ",$teacherNames);
        $client = ClientBuilder::create()
            ->addConnection('bolt', 'bolt://neo4j:12345678@10.3.55.50:7687')
            ->build();

        $status = 1;
        $list_teachers = array();
        foreach($arrNames as $teacherName) {
            
            $query = "MATCH (n:Teacher)  where n.name=~'.*(?i)$teacherName.*' RETURN distinct n";
            $queryresult = $client->run($query);
            $teachers = array();
            foreach ($queryresult->getRecords() as $record) {
                $status = 0;
                $record = (array)$record;
                $value = (array)$record["\0*\0values"][0];
                $teacher = array('');

                foreach($value["\0*\0properties"] as $x=>$x_value) {
                    $teacher[$x] = $x_value;
                }
                array_push($teachers, $teacher);
            }
            array_push($list_teachers, $teachers);
        }
        $result=array();
        $predata=array();
        $initial = array();
        $initial['teacherName'] = "";
        $initial['showWords'] = "";
        $initial['tnumber'] = "";
        array_push($predata, $initial);
        foreach($list_teachers as $teachers)
        {
            $nexdata = array();
            for($i=0;$i<count($predata);$i++)
            {
                $pre = $predata[$i];
                for($j=0;$j<count($teachers);$j++)
                {
                    $teacher = $teachers[$j];
                    if($pre['teacherName']=="")
                    {
                        $c1 = "";
                        $c2 = "";
                    }
                    else
                    {
                        $c1 = "  ;  ";
                        $c2 = ";";
                    }    
                    $temp=array();
                    $temp['teacherName'] = $pre['teacherName'].$c2.$teacher["name"];
                    $temp['showWords'] = $pre['showWords'].$c2.$teacher["name"]." ".$teacher["department"];
                    $temp['tnumber'] = $pre['tnumber'].$c2.$teacher["teacher_id"];
                    array_push($nexdata, $temp);
                    
                }
            }
            $predata = $nexdata;
        }
        if(count($arrNames)==1)
            $type = 0;
        else
            $type = 1;

        $result['status']=$status;
        $result['type']=$type;
        $result['data']=$predata;
        return json_encode($result);
    }
    //漫游图
}
