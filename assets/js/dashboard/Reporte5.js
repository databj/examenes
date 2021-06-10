$(function(){
   
///tarta de tasas 

    var contadorcodiesel=document.getElementById("ContadorCodiesel").value;
    jsoncontadorcodiesel=parseInt(contadorcodiesel);

    var contadorTdm=document.getElementById("contadorTdm").value;
    jsoncontadorTdm=parseInt(contadorTdm);

    var  contadorCemex=document.getElementById("contadorCemex").value;
    jsoncontadorCemex=parseInt(contadorCemex);
    

    contadorOpertrans=parseInt(document.getElementById("contadorOpertrans").value);
    contadorJp=parseInt(document.getElementById("contadorJp").value);
    contadorPc1=parseInt(document.getElementById("contadorPc1").value);
    contadorImalbesto=parseInt(document.getElementById("contadorImalbesto").value);
    contadorIsor=parseInt(document.getElementById("contadorIsor").value);
    contadorLafe=parseInt(document.getElementById("contadorLafe").value);
    contadorLink=parseInt(document.getElementById("contadorLink").value);
    contadorExyco=parseInt(document.getElementById("contadorExyco").value);
    contadorMesser=parseInt(document.getElementById("contadorMesser").value);
    contadorAvicola=parseInt(document.getElementById("contadorAvicola").value);
   
                        var a=[{
                            label:"Co-diesel "+jsoncontadorcodiesel,
                            fontFamily:"IBM Plex Sans, sans-serif",
                            foreColor:"#d93232",
                            data:[[1,jsoncontadorcodiesel]],
                            color:"#d93232"},
                            {
                            label:"Cemex "+jsoncontadorCemex,
                            data:[[1,jsoncontadorCemex]],
                            color:"#8595f5"},

                            {
                            label:"OperTrans "+contadorOpertrans,
                            data:[[1,contadorOpertrans]],
                            color:"#f2ec48"},
                        
                            {
                            label:"JP "+contadorJp,
                            data:[[1,contadorJp]],
                            color:"#2dfa71"},

                            {
                            label:"PC1 "+contadorPc1,
                            data:[[1,contadorPc1]],
                            color:"#faec2d"},

                            {
                            label:"Imalbesto "+contadorImalbesto,
                            data:[[1,contadorImalbesto]],
                            color:"#339c02"},

                            {
                            label:"Isor "+contadorIsor,
                            data:[[1,contadorIsor]],
                            color:"#09d9d9"},

                            {
                            label:"Lafe "+contadorLafe,
                            data:[[1,contadorLafe]],
                            color:"#f041aa"},
                            {
                            label:"Link "+contadorLink,
                            data:[[1,contadorLink]],
                            color:"#f71341"},
                            {
                            label:"Exyco "+contadorExyco,
                            data:[[1,contadorExyco]],
                            color:"#f5627f"},
                            {
                            label:"Messer "+contadorMesser,
                            data:[[1,contadorMesser]],
                            color:"#8595f5"},
                            {
                            label:"Avicola "+contadorAvicola,
                            data:[[1,contadorAvicola]],
                            color:"#eb9e38"},

                            {
                            label:"TDM "+jsoncontadorTdm,
                            data:[[1,jsoncontadorTdm]],
                            color:"#d941c5"}/*,
                            {
                            label:"Bounce Rate",
                            data:[[1,70]],
                            color:"#EE8CE5"}*/];

                    $.plot("#sessionsDeviceDonut",a,{
                        series:{
                            pie:{
                                show:true,
                                radius:1,
                                innerRadius:0.3,
                                label:{
                                    show:true,
                                    radius:2/3,
                                    formatter:c,
                                    threshold:0.1}}},
                                    grid:{
                                        hoverable:true,
                                        clickable:true}});
                                        
                    function c(e,f){return"<div style='font-size:7pt; text-align:center; padding:2px; color:white;'>"+e+"<br/>"+Math.round(f.percent)+"%</div>"}
                  
                  
                });