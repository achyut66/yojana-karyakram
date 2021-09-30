var JQ = jQuery.noConflict();
JQ(document).ready(function(){
      JQ.ajax({
           
                url: "get_yojana_report.php/",
                method : "post",
                success: function(data){
                   // console.log(data);
                    var obj = JSON.parse(data);
//                    alert(obj.msg); return false;
                    console.log(obj);
                    var yojana = [];
                    var count=[];
                    var bgcolors=[];
                    var hbcolors=[];
                    for(var i in obj)
                    {
                        yojana.push(obj[i].yojana);
                        count.push(obj[i].count);
                        bgcolors.push("rgba(" + obj[i].color+",0.75)");
                        hbcolors.push("rgba(" + obj[i].color+",1)");
                    }
                    var chardata = {
                        labels: yojana,
                        datasets:[{
                            label:'संख्या',
                            backgroundColor :bgcolors,
                            borderColor: bgcolors,
                            hoverBackgroundColor: hbcolors,
                            hoverBorderColor: hbcolors,
                            data:count
                        }]
                    };

                    var options = {
                        title :{
                            display: true,
                            position: 'top',
                            text :'योजनाको संख्या',
                            fontSize: 20,
                            fontColor : "#333"
                        },
                        legend :{
                            display: false,
                            position :'bottom'
                        },
                        scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                      };
                    var ctx = JQ("#yojana_report");
                    var graph = new Chart(ctx,
                    {
                        type: 'doughnut',
                        data: chardata,
                        options: options
                    });
                    for(var i=0;i<yojana.length;i++)
                    {
                        JQ(".yojana_"+i).css("background", bgcolors[i]);
                    }
                    JQ("#yojana_detail").show();
                },
                error: function(data){
                    console.log(data);
                }
               
            });
            JQ.ajax({
           
                url: "get_karyakam_report.php/",
                method : "post",
                success: function(data){
                   // console.log(data);
                    var obj = JSON.parse(data);
//                    alert(obj.msg); return false;
                    console.log(obj);
                    var yojana = [];
                    var count=[];
                    var bgcolors=[];
                    var hbcolors=[];
                    for(var i in obj)
                    {
                        yojana.push(obj[i].yojana);
                        count.push(obj[i].count);
                        bgcolors.push("rgba(" + obj[i].color+",0.75)");
                        hbcolors.push("rgba(" + obj[i].color+",1)");
                    }
                    var chardata = {
                        labels: yojana,
                        datasets:[{
                            label:'संख्या',
                            backgroundColor :bgcolors,
                            borderColor: bgcolors,
                            hoverBackgroundColor: hbcolors,
                            hoverBorderColor: hbcolors,
                            data:count
                        }]
                    };

                    var options = {
                        title :{
                            display: true,
                            position: 'top',
                            text :'कार्यकमको संख्या',
                            fontSize: 20,
                            fontColor : "#333"
                        },
                        legend :{
                            display: false,

                            position :'bottom'
                        },
                        scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                      };
                    var ctx = JQ("#yojana_report1");
                    var graph = new Chart(ctx,
                    {
                        type: 'bar',
                        data: chardata,
                        options: options
                    });
                     for(var i=0;i<yojana.length;i++)
                    {
                        JQ(".yojana1_"+i).css("background", bgcolors[i]);
                    }
                    JQ("#yojana_detail1").show();
                },
                error: function(data){
                    console.log(data);
                }
            });

            JQ.ajax({
           
                url: "get_yojana_report.php/",
                type: "POST",
                success: function(data){
                   // console.log(data);
                    var obj = JSON.parse(data);
//                    alert(obj.msg); return false;
                    console.log(obj);
                    var yojana = [];
                    var anudan=[];
                    var kharcha =[];
                    var baki = [];
                    for(var i in obj)
                    {
                        yojana.push(obj[i].yojana);
                        anudan.push(parseInt(obj[i].anudan));
                        kharcha.push(parseInt(obj[i].kharcha));
                        baki.push(parseInt(obj[i].baki));
                    }
                    
                    var chardata = {
                        labels: yojana,
                        datasets:[{
                            label:'जम्मा अनुदान',
                            backgroundColor: "blue",
                            data:anudan
                            },
                            {
                            label:'हाल सम्मको खर्च',
                            backgroundColor: 'red',
                            data:kharcha
                            },
                            {
                            label:'बाकी रकम ',
                            backgroundColor: 'green',
                            data:baki
                            }
                        ]
                    };

                    var options = {
                        title :{
                            display: true,
                            position: 'top',
                            text :'योजनाको रकम',
                            fontSize: 20,
                            fontColor : "#333"
                        },
                        legend :{
                            display: false,
                            position :'bottom'
                        },
                        scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                      };
                    var ctx = JQ("#yojana_report2");
                    var graph = new Chart(ctx,
                    {
                        type: 'bar',
                        data: chardata,
                        options: options
                    });
                    JQ(".yojana2_1").css("background","blue");
                    JQ(".yojana2_2").css("background","red");
                    JQ(".yojana2_3").css("background","green");
                    JQ("#yojana_detail2").show();
                },
                error: function(data){
                    console.log(data);
                }
            });
            JQ.ajax({
           
                url: "get_yojana_bikash_report.php/",
                type: "GET",
                success: function(data){
                   // console.log(data);
                    var obj = JSON.parse(data);
//                    alert(obj.msg); return false;
                    console.log(obj);
                    var topic = [];
                    var count=[];
                    var hbcolors=[];
                    var bgcolors=[];
                    for(var i in obj)
                    {
                        topic.push(obj[i].topic);
                        count.push(parseInt(obj[i].count));
                        bgcolors.push("rgba(" + obj[i].color+",0.75)");
                        hbcolors.push("rgba(" + obj[i].color+",1)");
                    }
                    
                    var chardata = {
                        labels: topic,
                        datasets:[{
                            label:'कुल संख्या',
                            backgroundColor: bgcolors,
                            borderColor: bgcolors,
                            hoverBackgroundColor: hbcolors,
                            hoverBorderColor: hbcolors,
                            data:count
                            }]
                    };

                    var options = {
                        title :{
                            display: true,
                            position: 'top',
                            text :'योजनाको अन्तर्गत बिकाशको रिपोर्ट',
                            fontSize: 20,
                            fontColor : "#333"
                        },
                        legend :{
                            display: false,

                            position :'bottom'
                        },
                        scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                      };
                    var ctx = JQ("#yojana_report3");
                    var graph = new Chart(ctx,
                    {
                        type: 'doughnut',
                        data: chardata,
                        options: options
                    });
                     for(var i=0;i<topic.length;i++)
                    {
                        JQ(".yojana3_"+i).css("background", bgcolors[i]);
                    }
                    JQ("#yojana_detail3").show();
                },
                error: function(data){
                    console.log(data);
                }
            });
        
});