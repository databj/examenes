
        //// Index lamina 1
        document.addEventListener('DOMContentLoaded', function() {
        


    var cero=[0,0,0,0,0,0,0];

            var vector=document.getElementById("contadorGeneral").value;
            json=JSON.parse(vector);

    
            var vector2=document.getElementById("ContadorGeneralDiarioCodiesel").value;
            json2=JSON.parse(vector2);
    
            var vector3=document.getElementById("ContadorGeneralDiarioCemex").value;
            json3=JSON.parse(vector3);

            var vector4=document.getElementById("contadorDiario").value;
            json4=JSON.parse(vector4);

            var vector5=document.getElementById("contadorGeneralOpertrans").value;
            json5=JSON.parse(vector5);

            var vector6=document.getElementById("contadorGeneralJp").value;
            json6=JSON.parse(vector6);

            var vector7=document.getElementById("contadorGeneralTdm").value;
            json7=JSON.parse(vector7);


            var vector8=document.getElementById("contadorGeneralPc1").value;
            json8=JSON.parse(vector8);
            var vector9=document.getElementById("contadorGeneralImalbesto").value;
            json9=JSON.parse(vector9);
            var vector10=document.getElementById("contadorGeneralIsor").value;
            json10=JSON.parse(vector10);
            var vector11=document.getElementById("contadorGeneralLafe").value;
            json11=JSON.parse(vector11);
            var vector12=document.getElementById("contadorGeneralLink").value;
            json12=JSON.parse(vector12);
            var vector13=document.getElementById("contadorGeneralExyco").value;
            json13=JSON.parse(vector13);
            var vector14=document.getElementById("contadorGeneralMesser").value;
            json14=JSON.parse(vector14);
            var vector15=document.getElementById("contadorGeneralAvicola").value;
            json15=JSON.parse(vector15);

           

            
           var MAXIMO=0;
           for (let index = 0; index < json2.length; index++) {
                const element = json2[index];
              
                if(element>MAXIMO){
                    MAXIMO=element;
                }
            }
            
            


        
        var a=document.getElementById("Report1");
new Chart(a,
    {
        type:"line",data:{labels:["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"],
datasets:[
    {
        
        label:"TOTAL",
        data:cero,
        backgroundColor:"rgba(0, 204, 204, .2)", //listo
        borderWidth:1,
        fill:true},
    {
        label:"Co-Diesel ",
        data:json2,
        backgroundColor:"rgba(240, 9, 25, .2)",//listo
        borderWidth:1,fill:true},
    {
        label:"OperTrans",
        data:json5,
        backgroundColor:"rgba(230, 230, 23, .2)",
        borderWidth:1,fill:true},
    {
        label:"PortCargo",
        data:json8,
        backgroundColor:"rgba(230, 230, 23, .2)",
        borderWidth:1,fill:true},
    {
        label:"Tdm",
        data:json7,
        backgroundColor:"rgba(242, 5, 202, .2)",
        borderWidth:1,fill:true},
    {
        label:"JP",
        data:json6,
        backgroundColor:"rgba(23, 230, 99, .2)",
        borderWidth:1,fill:true},
    {
        label:"Imalbesto",
        data:json9,
        backgroundColor:"rgba(33, 168, 24, .2)",
        borderWidth:1,fill:true},
    {
        label:"Isor",
        data:json10,
        backgroundColor:"rgba(0, 255, 217, .2)",
        borderWidth:1,fill:true}, 
    {
        label:"Lafe",
        data:json11,
        backgroundColor:"rgba(248, 127, 186, .2)",
        borderWidth:1,fill:true},
    {
        label:"Link",
        data:json12,
        backgroundColor:"rgba(252, 0, 0, .2)",
        borderWidth:1,fill:true},
    {
        label:"Exyco",
        data:json13,
        backgroundColor:"rgba(248, 127, 186, .2)",
        borderWidth:1,fill:true},
    {
        label:"Messer",
        data:json14,
        backgroundColor:"rgba(248, 127, 186, .2)",
        borderWidth:1,fill:true},
    {
        label:"Avicola",
        data:json15,
        backgroundColor:"rgba(248, 127, 186, .2)",
        borderWidth:1,fill:true},   
    {
    
        label:"Cemex",
        data:json3,
        backgroundColor:"rgba(152, 194, 252, .2)",//listo
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
                                fontColor:"#8392a5",max:MAXIMO+5}}],
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
                    var d=new ApexCharts(document.querySelector("#salesSpark2"),d);d.render();
                    var c=new ApexCharts(document.querySelector("#salesSpark3"),c);c.render();




                    
                                });


                    
/////////////////////////////////
