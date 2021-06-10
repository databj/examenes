#!/bin/sh

#Url del servicio checkpdf
url="http://www.altiria.net/apirest/ws/checkPdfFile"

#$1 Parametro de entrada: identificador obtenido como respuesta al servicio "certpdf" en el elemento "id"

#XX, YY y ZZ se corresponden con los valores 
#de identificacion del usuario en el sistema.
#domainId solo es necesario si el login no es un email

generate_post_data="{\"credentials\":{\"domainId\":\"XX\",\"login\":\"YY\",\"passwd\":\"ZZ\"},\"query\":{\"id\":\"$1\"}}"

#echo $generate_post_data

response=$(curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data `echo $generate_post_data` "$url")

echo "Respuesta al servicio checkpdf: $response"

exit 0
