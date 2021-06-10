#!/bin/sh

#$1 Parametro de entrada: url obtenida como respuesta al servicio "certpdf" en el elemento "url"

#Ruta local al fichero a subir para su certificacion
path="/tmp/fichero.pdf"

response=$(curl -i \
-H "Content-Type:application/pdf" \
-X POST --data-binary @"$path" "$1")

echo "Respuesta al servicio uploadfile: $response"

exit 0
