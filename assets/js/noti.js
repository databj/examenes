

                function notificacion($var){
                 
                 setTimeout(
                     function(){toastr.options={positionClass:"toast-top-right",
                     closeButton:true,progressBar:true,showMethod:"slideDown",timeOut:5000};
                     toastr.info("notificacion",$var)},300)
                    
                    };


                     
                    function prueba($prueba){
                        setTimeout(function(){
                            toastr.options={
                                positionClass:"toast-top-right",
                                closeButton:true,progressBar:true,showMethod:"slideDown",
                                timeOut:5000};
                                toastr.info("notificacion",$prueba)},300)};