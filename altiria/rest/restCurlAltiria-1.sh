#!/bin/sh

#Url del servicio certpdf
url="http://www.altiria.net/apirest/ws/certPdfFile"


#XX, YY y ZZ se corresponden con los valores 
#de identificacion del usuario en el sistema.
#domainId solo es necesario si el login no es un email

generate_post_data() {
  cat <<EOF
{
  "credentials": {
    "domainId": "XX",
    "login": "YY",
    "passwd": "ZZ"
  },
  "document": {
    "destination": "346xxxxxxxx",
    "type": "premium",
    "webSig": true
  }
}
EOF
}


response=$(curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data "$(generate_post_data)" "$url")

echo "Respuesta al servicio certpdf: $response"

exit 0
