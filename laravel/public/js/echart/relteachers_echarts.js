$(document).ready(function(){
    graph = JSON.parse(graph);
    persons_json = JSON.parse(persons_json);
    // console.log('json object',graph);
    
    /* graph = array();
    graph["nodes"] = array();
    graph["links"] = array();
    node = array();
    node["name"] = "纪阳";
    node["category"] = "Teacher";
    node["symbolSize"] = 100;
    array_push(graph["nodes"], node);
    */
    var myChart = echarts.init(document.getElementById('app'));

    myChart.showLoading();
    // $.get('data/asset/data/les-miserables.gexf', function (xml) {
        myChart.hideLoading();
        // var app = {};
        // option = null;
        // var graph = echarts.dataTool.gexf.parse(xml);
        var categories = [];
        
        categories[0] = {
                name: '中心教师'
        };
        categories[1] = {
                name: '论文'
        };
        categories[2] = {
                name: '课程'
        };
        categories[3] = {
                name: '专著专利'
        };
        persons_json.forEach(function (node) {
            
            cat = {
                name: node + '合作教师',
            };
            categories.push(cat);
        });
        
        console.log(categories);
        graph.nodes.forEach(function (node) {
            node.itemStyle = null;
            // node.value = ;
            //node.symbolSize /= 1.5;
            node.label = {
                normal: {
                    show: node.symbolSize > 25
                }
            };
            node.category = node.category;
            // node.tooltip = {
            //     formatter: '{b0}:{c0}'    
            // }
        });
        var option = {
            title: {
                text: '多名教师合作关系图',
                subtext: 'Default layout',
                top: 'bottom',
                left: 'right'
            },
            tooltip: {
                triggerOn:"mousemove",
                showcontent:true
                 },
            legend: [{
                // selectedMode: 'single',
                data: categories.map(function (a) {
                    return a.name;
                })
            }],
            animationDuration: 1500,
            animationEasingUpdate: 'quinticInOut',
            series : [
                {
                    name: '教师合作关系图',
                    type: 'graph',
                    layout: 'force',
                    data: graph.nodes,
                    links: graph.links,
                    categories: [
                    { 
                        name:'教师搜索词',
                        symbol:'circle',
                        itemStyle:{
                            color:'#c23531'
                        },

                    },
                    { 
                        name:'论文',
                        symbol:'triangle',
                        itemStyle:{
                            color:'#6ea0a8'
                        }

                    },
                    {   
                        name:'课程',
                        symbol:'triangle',
                        itemStyle:{
                            color:'#6e7074'
                        }

                    },
                    {   
                        name:'专著专利',
                        symbol:'triangle',
                        itemStyle:{
                            color:'#2f4554'
                        }

                    },
                    /* {
                        name:'Cootor',
                        itemStyle:{
                            color:'#dd9fa5'
                        }
                    }*/
                    ],
                    roam: true,
                    focusNodeAdjacency: true,
                    itemStyle: {
                        normal: {
                            borderColor: '#fff',
                            borderWidth: 1,
                            shadowBlur: 10,
                            shadowColor: 'rgba(0, 0, 0, 0.3)'
                        }
                    },
                    label: {
                        position: 'right',
                        formatter: '{b}'
                    },
                    lineStyle: {
                        color: 'target',
                        curveness: 0.3
                    },
                    emphasis: {
                        lineStyle: {
                            width: 10
                        }
                    },
                    //circular:{
                    //    rotateLabel: false
                    //}
                    force:{
                        repulsion:175
                    }
                }
            ]
        };
        persons_json.forEach(function (node) {
            cat = {
                name: node + '合作教师',
                itemStyle:{
                    color:'#bda29a'    
                }
            };
            option.series[0].categories.push(cat);
        });
        console.log(categories);
        myChart.setOption(option);
    }, 'xml');
