$(document).ready(function(){

    teachers = JSON.parse(teachers);
    console.log('json object',teachers);

    var myChart = echarts.init(document.getElementById('app'));

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
            data:['论文','专著专利','课程']
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
                data : ['1995-1999','2000-2004','2005-2009','2010-2014','2015-2019']
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'论文',
                type:'line',
                stack: '总量',
                label:{
                    normal:{
                        show: true,
                        position: 'top'
                    }
                },
                areaStyle: {normal: {}},
                data:[3,5,3,5,4]
            },
            {
                name:'专著专利',
                type:'line',
                stack: '总量',
                label:{
                    normal:{
                        show: true,
                        position: 'top'
                    }
                },
                areaStyle: {normal: {}},
                data:[8,10,8,10,11]
            },
            {
                name:'课程',
                type:'line',
                stack: '总量',
                label: {
                    normal: {
                        show: true,
                        position: 'top'
                    }
                },
                areaStyle: {normal: {}},
                data:[2,3,2,3,4]
                }
        ]
    };
    myChart.setOption(option);
});
