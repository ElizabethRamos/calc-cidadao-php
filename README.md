# calc-cidadao-php
JSON API PHP wrapper for Calculadora do Cidadão

To return the value corrected by the Selic according to the Citizen's Calculator:

$ curl http://localhost:8000/selic -d "dataInicial=dd/mm/yyyy" -d "dataFinal=dd/mm/yyyy" -d "valorCorrecao=0000,00" -X POST

Inspired by:  https://github.com/bcfurtado/calculadoradocidadao, Thanks @bcfurtado!
