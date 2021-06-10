//contador semana por empresas 3
        
        document.addEventListener('DOMContentLoaded', function() {
        


    


            var contadorSemanal=document.getElementById("contadorSemanalanual").value;
            jsonContadorSemanal=JSON.parse(contadorSemanal);

            
            
         


////////////////////


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
                                                            series:[{data:jsonContadorSemanal}],yaxis:{min:0},
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
                                                                series:[{data:[]}],
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
                                                                series:[{data:[]}],
                                                                xaxis:{crosshairs:{width:1},},
                                                                yaxis:{min:0},colors:["#EE8CE5"],};

                    var h=new ApexCharts(document.querySelector("#salesSpark11"),h);h.render();
                    var d=new ApexCharts(document.querySelector("#salesSpark22"),d);d.render();
                    var c=new ApexCharts(document.querySelector("#salesSpark33"),c);c.render();




                    
                                });


                    
/////////////////////////////////
