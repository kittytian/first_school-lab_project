<?php

namespace App\Http\Controllers;

//require_once '../vendor/autoload.php';

use Illuminate\Http\Request;
use GraphAware\Neo4j\Client\ClientBuilder;

class TeacherController extends Controller
{
    public function search(Request $request)
    {
        $teacherName = $request->input('teacherName');

        $client = ClientBuilder::create()
            ->addConnection('bolt', 'bolt://neo4j:12345678@10.3.55.50:7687')
            ->build();

        $query_courses = "match (n:Teacher {name:'{$teacherName}'})-[r]->(c:Course) return distinct c";
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

        $query_papers = "match (t:Teacher{name:'{$teacherName}'})-[r]->(p:Publication) where p.publication_type='期刊论文' or (p.publication_type='会议论文') or (p.publication_type='学位论文') return distinct p ORDER BY p.publication_date DESC;";
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

        $query_books = "match (t:Teacher{name:'{$teacherName}'})-[r]->(p:Publication) where p.publication_type='图书专著' or (p.publication_type='专利文献') return distinct p ORDER BY p.publication_date DESC;";
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

        $query_years_by_paper = "match (t:Teacher{name:'{$teacherName}'})-[r]->(p:Publication) where p.publication_type='期刊论文' or (p.publication_type='会议论文') or (p.publication_type='学位论文') return distinct p.publication_date;";
        $result_years_by_paper = $client->run($query_years_by_paper);
        $years_by_paper = array();
        foreach ($result_years_by_paper->getRecords() as $record) {
            $record = (array)$record;
            $value = (array)$record["\0*\0values"];
            foreach($value as $x_value) {
                $year = substr($x_value, 0, 4);
                $num = count($years_by_paper);
                $flag = true;
                for($i=0;$i<$num;$i++) 
                    if($years_by_paper[$i] == $year){
                        $flag = false;
                        break;
                    }
                if($flag == true) {
                    array_push($years_by_paper, $year);
                }
            }
        }
        rsort($years_by_paper);
        $papers_all_year = array();
        foreach ($years_by_paper as $each_year) {
            $query_papers_each_year = "match (t:Teacher{name:'{$teacherName}'})-[r]->(p:Publication) where p.publication_date starts with '{$each_year}' and ( p.publication_type='期刊论文' or (p.publication_type='会议论文') or (p.publication_type='学位论文') ) return distinct p ORDER BY p.publication_date DESC;";
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
        
        $query_years_by_book = "match (t:Teacher{name:'{$teacherName}'})-[r]->(p:Publication) where p.publication_type='图书专著' or (p.publication_type='专利文献') return distinct p.publication_date;";
        $result_years_by_book = $client->run($query_years_by_book);
        $years_by_book = array();
        foreach ($result_years_by_book->getRecords() as $record) {
            $record = (array)$record;
            $value = (array)$record["\0*\0values"];
            foreach($value as $x_value) {
                $year = substr($x_value, 0, 4);
                $num = count($years_by_book);
                $flag = true;
                for($i=0;$i<$num;$i++)
                    if($years_by_book[$i] == $year) {
                        $flag = false;
                        break;
                    }
                if($flag == true) {
                    array_push($years_by_book, $year);
                }
            }
        }
        rsort($years_by_book);
        $books_all_year = array();
        foreach ($years_by_book as $each_year) {
            $query_books_each_year = "match (t:Teacher{name:'{$teacherName}'})-[r]->(p:Publication) where p.publication_date starts with '{$each_year}' and ( p.publication_type='图书专著' or (p.publication_type='专利文献') ) return distinct p ORDER BY p.publication_date DESC;";
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

        //dd($years_by_paper);
        //echo json_encode((object)$json);
        return view('teacher',['courses'=>$courses, 'papers'=>$papers, 'books'=>$books, 'years_by_paper'=>$years_by_paper, 'papers_all_year'=>$papers_all_year, 'years_by_book'=>$years_by_book, 'books_all_year'=>$books_all_year]);
    }
    
    public function index() {
        return view('search');
    }    
}
