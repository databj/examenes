
        //// Index lamina 1
        document.addEventListener('DOMContentLoaded', function() {
        


    

            var vector=document.getElementById("contadorGeneralEmpresa").value;
            json=JSON.parse(vector);
    
            var vector2=document.getElementById("ContadorGeneralDiarioCodieselEmpresa").value;
            json2=JSON.parse(vector2);
    
            var vector3=document.getElementById("ContadorGeneralDiarioCemexEmpresa").value;
            json3=JSON.parse(vector3);

            var vector4=document.getElementById("contadorDiarioEmpresa").value;
            json4=JSON.parse(vector4);

            
            
            


        
        var a=document.getElementById("Report1");
new Chart(a,
    {
        type:"line",data:{labels:["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"],
datasets:[
    {
        
        label:"TOTAL",
        data:json,
        backgroundColor:"rgba(0, 204, 204, .2)",
        borderWidth:1,
        fill:true},
    {
        label:"Co-Diesel ",
        data:json2,
        backgroundColor:"rgba(248, 127, 186, .2)",
        borderWidth:1,fill:true},
    {
        label:"Cemex",
        data:json3,
        backgroundColor:"rgba(152, 194, 252, .2)",
        borderWidth:1,
        fill:true}
    
    ]},
        
        options:{
            legend:{
                display:true,
            labels:{
                    display:true,
                    fontFamily:"IBM Plex Sans, sans-serif",
                    fontColor:"#8392a5",}},

                    scales:{
                        yAxes:[
                            {
                                ticks:{
                                beginAtZero:true,
                                fontSize:12,
                                fontFamily:"IBM Plex Sans, sans-serif",
                                fontColor:"#8392a5",max:100}}],
                        xAxes:[
                            {
                                ticks:{
                                    beginAtZero:true,
                                    fontSize:11,
                                    fontFamily:"IBM Plex Sans, sans-serif",
                                    fontColor:"#8392a5",}}]}}});
/////////////

///////3 entradas semanal por empresa


                                            window.Apex={
                                                stroke:{width:1},
                                                markers:{size:0},
                                                tooltip:{fixed:{enabled:true,}}};
                                          
                                                   
                                                var h={
                                                        chart:{
                                                            type:"area",
                                                            height:60,
                                                            fontFamily:"IBM Plex Sans, sans-serif",
                                                            foreColor:"#8392a5",
                                                            sparkline:{enabled:true},},
                                                            stroke:{curve:"straight"},
                                                            fill:{opacity:0.3,},
                                                            series:[{data:json4}],yaxis:{min:0},
                                                            colors:["#04CAD0"],};

                    
                                                var d={
                                                        chart:{
                                                            type:"area",
                                                            height:60,
                                                            fontFamily:"IBM Plex Sans, sans-serif",
                                                            foreColor:"#8392a5",
                                                            sparkline:{
                                                                enabled:true},},
                                                                stroke:{curve:"straight"},
                                                                fill:{opacity:0.3,},
                                                                series:[{data:json2}],
                                                                yaxis:{min:0},colors:["#4285F4"],};
                                                            
                                                var c={
                                                        chart:{
                                                            type:"area",
                                                            height:60,
                                                            fontFamily:"IBM Plex Sans, sans-serif",
                                                            foreColor:"#8392a5",
                                                            sparkline:{
                                                                enabled:true},},
                                                                stroke:{curve:"straight"},
                                                                fill:{opacity:0.3},
                                                                series:[{data:json3}],
                                                                xaxis:{crosshairs:{width:1},},
                                                                yaxis:{min:0},colors:["#EE8CE5"],};

                    var h=new ApexCharts(document.querySelector("#salesSpark1"),h);h.render();
                    




                    
                                });


                    
/////////////////////////////////
