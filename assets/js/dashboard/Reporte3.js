/// versus semanal
        
        document.addEventListener('DOMContentLoaded', function() {
        


    

            var vector=document.getElementById("ContadorTotal").value;
            json=JSON.parse(vector);
    
            var vector2=document.getElementById("ContadorSemanaActual").value;
            json2=JSON.parse(vector2);
    
            var vector3=document.getElementById("ContadorSemanaPasada").value;
            json3=JSON.parse(vector3);

           
            var semana3=document.getElementById("ContadorSemana3").value;
            jsonsemana3=JSON.parse(semana3);

            var semana4=document.getElementById("ContadorSemana4").value;
            jsonsemana4=JSON.parse(semana4);

            var semana5=document.getElementById("ContadorSemana5").value;
            jsonsemana5=JSON.parse(semana5);

           
            
            
            


        
        var a=document.getElementById("Report2");
new Chart(a,
    {
        type:"line",data:{labels:["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"],
datasets:[
   /* {
        
        label:"TOTAL",
        data:json,
        backgroundColor:"rgba(0, 204, 204, .2)",
        borderWidth:1,
        fill:true},*/
    {
        label:"Semana Actual",
        data:json2,
        backgroundColor:"rgba(248, 127, 186, .2)",
        borderWidth:1,fill:true},
    {
        label:"Semana Pasada",
        data:json3,
        backgroundColor:"rgba(152, 194, 252, .2)",
        borderWidth:1,
        fill:true},
    {
        label:"3 Semanas Atras",
        data:jsonsemana3,
        backgroundColor:"rgba(11, 147, 79, .2)",
        borderWidth:1,
        fill:true},
    {
        label:"4 Semanas Atras",
        data:jsonsemana4,
        backgroundColor:"rgba(20, 107, 63, .2)",
        borderWidth:1,
        fill:true},
    {
        label:"5 Semanas Atras",
        data:jsonsemana5,
        backgroundColor:"rgba(32, 94, 63, .2)",
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
                                fontColor:"#8392a5",max:50}}],
                        xAxes:[
                            {
                                ticks:{
                                    beginAtZero:true,
                                    fontSize:11,
                                    fontFamily:"IBM Plex Sans, sans-serif",
                                    fontColor:"#8392a5",}}]}}});
////////////////////





                    
                                });


                    
/////////////////////////////////
