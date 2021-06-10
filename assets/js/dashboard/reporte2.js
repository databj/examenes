
                     ///////vista mensual///////
                
        
        document.addEventListener('DOMContentLoaded', function() {
        
            var vector=document.getElementById("contadorMensual").value;
            json=JSON.parse(vector);
       
                     var m={chart:{
                                    height:330,
                                    type:"bar",
                                    fontFamily:"IBM Plex Sans, sans-serif",
                                    foreColor:"#8392a5",},
                                    plotOptions:{bar:{horizontal:false,columnWidth:"50%"},},
                                    dataLabels:{enabled:false},
                                    stroke:{
                                        show:true,
                                        width:2,
                                        colors:["transparent"]},
                                    series:[{
                                        name:"Datos",data:[]},{
                                        name:"Datos2",data:[]},{
                                        name:"Total de Entradas",data:json}],
                                            colors:["#66a4fb","#e4eaff","#65e0e0"],
                                            xaxis:{
                                                categories:["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],},
                                            yaxis:{
                                                title:{
                                                    text:"# ENTRADAS"}},
                                            fill:{opacity:1},
                                            tooltip:{
                                                y:{formatter:function(o){return" "+o+" ENTRADAS"}}}};
                                var k=new ApexCharts(document.querySelector("#salesRevenueBarChart"),m);
                                k.render();
            
                                


                    
                            });

                    