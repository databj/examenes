$(function()
{

    var vector=document.getElementById("anioprueba").value;
    json=JSON.parse(vector);

    var Primer_elemento=document.getElementById("inicio").value;
    var Ultimo_elemento=document.getElementById("fin").value;

    var t=q(new Date("01 Jan 2021").getTime(),365,{min:0,max:50});
var v=
{
    chart:{
    id:"chart2",
    type:"area",
    height:300,
    fontFamily:"IBM Plex Sans, sans-serif",
    foreColor:"#6780B1",
    toolbar:{
        autoSelected:"pan",
        show:false}},
        colors:["#4285F4"],
        stroke:{width:1},
        grid:{
            borderColor:"#C8DCFC",
            clipMarkers:false,
            yaxis:{lines:{show:false}}},
            dataLabels:{enabled:false},
            fill:{
                gradient:{
                enabled:true,
                opacityFrom:0.5,
                opacityTo:0}},
                markers:{
                    size:5,
                    colors:["#4285F4"],
                    strokeColor:"#fff",
                    strokeWidth:1},
                    series:[{data:t}],
                    tooltip:{theme:"dark"},
                    xaxis:{type:"datetime"},
                    yaxis:{min:0,tickAmount:5}};


        var s=new ApexCharts(document.querySelector("#chart-area"),v);
        s.render();

        var u={chart:{
            id:"chart1",
            height:220,
            type:"bar",
            fontFamily:"IBM Plex Sans, sans-serif",
            foreColor:"#6780B1",
            brush:{target:"chart2",enabled:true},
            selection:{enabled:true,fill:{color:"#84BCFF",opacity:0.5},
            xaxis:{
                min:new Date(Primer_elemento).getTime(),
                max:new Date(Ultimo_elemento).getTime()}}},
            plotOptions:{bar:{columnWidth:"25%",endingShape:"rounded"}},
            dataLabels:{enabled:false},
            colors:["#4285F4"],
            series:[{data:t}],
            stroke:{width:1},
            grid:{borderColor:"#C8DCFC"},
            markers:{size:0},
            xaxis:{type:"datetime",tooltip:{enabled:false}},
            yaxis:{tickAmount:5}};
            var r=new ApexCharts(document.querySelector("#chart-bar"),u);
            r.render();

            function q(C,D,B){
                var A=0;var z=[];
                while(A<D){
                    var w=C;
                    var E=Math.floor(
                        Math.random()*(B.max-B.min+1))+B.min;
                       
                        z.push([w,json[A]]);
                        C+=86400000;
                        A++}

                        return z}});