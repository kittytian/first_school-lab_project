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
                name: '中心教师'
        };
        categories[1] = {
                name: '论文合作教师'
        };
        categories[2] = {
                name: '论文'
        };
        categories[3] = {
                name: '专著专利合作教师'
        };
        categories[4] = {
                name: '专著专利'
        };
        categories[5] = {
                name: '课程合作教师'
        };
        categories[6] = {
                name: '课程'
        };
        categories[7] = {
                name: '项目'
        };

        
        graph.nodes.forEach(function (node) {
            node.itemStyle = null;
            //node.value = node.symbolSize;
            //node.symbolSize /= 1.5;
            node.label = {
                normal: {
                    show: node.symbolSize > 15
                }
            };
            node.category = node.category;
        });
        var option = {
            title: {
                text: '教师合作关系图',
                subtext: 'Default layout',
                top: 'bottom',
                left: 'right'
            },
            tooltip: {triggerOn:"mousemove",
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
                    // name: '',
                    type: 'graph',
                    layout: 'force',
                    data: graph.nodes,
                    links: graph.links,
                     categories: [
                    { name:'中心教师',
                      itemStyle:{
                        color:'#c23531'
                      },

                    },
                     { name:'专著专利合作教师',
                      itemStyle:{
                        color:'#749f83'
                      },

                    },
                     { name:'课程合作教师',
                      itemStyle:{
                        color:'#6e7074'
                      },

                    },
                     { name:'论文合作教师',
                      itemStyle:{
                        color:'#2f4554'
                      },

                    },
                     { name:'论文',
                      itemStyle:{
                        color:'#61a0a8'
                      },

                    },
                    { name:'专著专利',
                      itemStyle:{
                        color:'#91c7ae'
                      },

                    },
                    { name:'课程',
                      itemStyle:{
                        color:'#999ea4'
                      },
                      

                    },
                      { name:'项目',
                        itemStyle:{
                              color:'#bda29a'
                          },

                      }
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

        teachers = JSON.parse(teachers);
        DateCount = JSON.parse(DateCount);

        var myChart = echarts.init(document.getElementById('app_research'));

        var years = new Array();
        for (i=1995; i<2020; i++) {
            years.push(String(i));    
        }

        var option = {
            title: {
                text: '年份趋势图'
            },
            tooltip : {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    label: {
                        backgroundColor: '#6a7985'
                    }
                }
            },
            legend: {
                data:['项目','专著专利','论文']
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            grid: {
                left: '3%',
                right: '5%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : years
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'项目',
                    type:'line',
                    stack: '总量',
                    label:{
                        normal:{
                            show: false,
                            position: 'top'
                        }
                    },
                    areaStyle: {normal: {}},
                    data:DateCount[0]
                },
                {
                    name:'专著专利',
                    type:'line',
                    stack: '总量',
                    label:{
                        normal:{
                            show: false,
                            position: 'top'
                        }
                    },
                    areaStyle: {normal: {}},
                    data:DateCount[1]
                },
                {
                    name:'论文',
                    type:'line',
                    stack: '总量',
                    label:{
                        normal:{
                            show: false,
                            position: 'top'
                        }
                    },
                    areaStyle: {normal: {}},
                    data:DateCount[2]
                },
            ]
        };
        myChart.setOption(option);
    }, 'xml');
