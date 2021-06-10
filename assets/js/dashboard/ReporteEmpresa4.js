/// versus semanal
        
document.addEventListener('DOMContentLoaded', function() {
        


    

    var vectorEmpresa=document.getElementById("ContadorTotalEmpresa").value;
    jsonEmpresa=JSON.parse(vectorEmpresa);

    var vector2Empresa=document.getElementById("ContadorSemanaActualEmpresa").value;
    json2Empresa=JSON.parse(vector2Empresa);

    var vector3Empresa=document.getElementById("ContadorSemanaPasadaEmpresa").value;
    json3Empresa=JSON.parse(vector3Empresa);

   

    
    
    



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
data:json2Empresa,
backgroundColor:"rgba(248, 127, 186, .2)",
borderWidth:1,fill:true},
{
label:"Semana Pasada",
data:json3Empresa,
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
