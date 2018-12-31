$(document).ready(function(){
    graph = JSON.parse(graph);
    console.log('json object',graph);
    
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
                name: '课程'
        };
        categories[1] = {
                name: '授课教师'
        };
        categories[2] = {
                name: '先修课程'
        };
        categories[3] = {
                name: '后续课程'
        };
        // console.log('json object',categories);
        graph.nodes.forEach(function (node) {
            node.itemStyle = null;
            //node.value = node.symbolSize;
            //node.symbolSize /= 1.5;
            node.label = {
                normal: {
                    show: node.symbolSize > 5
                }
            };
            node.category = node.category;
        });
        var option = {
            title: {
                text: '课程教师关系图',
                subtext: 'Default layout',
                top: 'bottom',
                left: 'right'
            },
            tooltip: {
                triggerOn:"mousemove",
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
                    name: '课程教师关系图',
                    type: 'graph',
                    layout: 'force',
                    data: graph.nodes,
                    links: graph.links,
                    categories: [{ 
                        name:'课程',
                        itemStyle:{
                            color:'#2f4554'
                        }
                    },
                    { 
                        name:'授课教师',
                        itemStyle:{
                            color:'#d48265'
                        }
                    },
                    {
                        name:'先修课程',
                        itemStyle:{
                            color:'#61a0a8'
                        }
                    },
                    {
                        name:'后续课程',
                        itemStyle:{
                            color:'#749f83'
                        }
                    },
                    
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
                    force:{    
                        repulsion: 175
                    }
                }
            ]
        };

        myChart.setOption(option);
    }, 'xml');
