<?php
/**
 * Reporte Personal Dinámico
 * 
 * Este script carga datos de un archivo JSON y los presenta en un formato moderno.
 */

// Variable para el JSON - puedes reemplazarlo con tu JSON aquí
$json = '{
"nombre": "BOLIVAR ERNESTO VALERA ARIZA",
"cedula": "00114935240",
"profesion": "ARTISTA",
"estado_civil": "S",
"sexo": "M",
"fecha_nacimiento": "20-06-1981",
"edad": 43,
"nacionalidad": "DOMINICANA",
"correo": "felix.jeiren.jeileen@gmail.com",
"gestion": "si",
"repeticiones": 2,
"foto": "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",
"empleos": [
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2025-04-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2025-04-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2025-03-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2025-03-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2025-02-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2025-02-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2025-01-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2025-01-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2024-12-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2024-12-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2024-10-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2024-10-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2024-09-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2024-09-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2024-08-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2024-08-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2024-07-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2024-07-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2024-06-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2024-06-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2024-05-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2024-05-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2024-04-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2024-04-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2024-03-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2024-03-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2024-02-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2024-02-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2024-01-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2024-01-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2023-11-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2023-11-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2023-12-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2023-12-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2023-10-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2023-10-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2023-09-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2023-09-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2023-08-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2023-08-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2023-07-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2023-07-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2023-06-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2023-06-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2023-05-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2023-05-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2023-04-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2023-04-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2023-03-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2023-03-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2023-02-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2023-02-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2023-01-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2023-01-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2022-12-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2022-12-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2022-11-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2022-11-01"
},
{
"rnc_empleador": "202210",
"nombre_empleador": null,
"salario": "0.00",
"periodo": "2022-10-01"
},
{
"rnc_empleador": "202210",
"nombre_empleador": null,
"salario": "0.00",
"periodo": "2022-10-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "368000.00",
"periodo": "2022-09-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2022-09-01"
},
{
"rnc_empleador": "401007606",
"nombre_empleador": "CAMARA DE DIPUTADOS DE LA REPUBLICA",
"salario": "210569.58",
"periodo": "2022-08-01"
},
{
"rnc_empleador": "130969957",
"nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
"salario": "100000.00",
"periodo": "2022-08-01"
}
],
"relaciones": [
{
"cedula": "40205298124",
"nombre": "BOLIVAR ANDRES VALERA PICHARDO",
"relacion": "Hijo/a"
},
{
"cedula": "40245595729",
"nombre": "ISABEL MERCEDES VALERA GAUTREAU",
"relacion": "Hijo/a"
}
],
"posibles_relacionados": [
{
"cedula": "00102822418",
"nombre": "ROSA ISABEL ARIZA MEDRANO DE VALERA",
"relacion": "Posible Relacion"
},
{
"cedula": "00110591179",
"nombre": "BOLIVAR ANTONIO VALERA DE LEON",
"relacion": "Posible Relacion"
},
{
"cedula": "00112835517",
"nombre": "ROSA IVELISSE VALERA ARIZA",
"relacion": "Posible Relacion"
},
{
"cedula": "00111072807",
"nombre": "FEDERICO MIGUEL VALERA ARIZA",
"relacion": "Posible Relacion"
},
{
"cedula": "00112964861",
"nombre": "ALTAGRACIA YAHOSKA SOTO VALERA",
"relacion": "Posible Relacion"
},
{
"cedula": "00100259605",
"nombre": "MARIA RAMONA ARIZA MEDRANO",
"relacion": "Posible Relacion"
}
],
"vehiculos": [
{
"marca": "GACELA",
"modelo": "BULLET 150",
"ano": 2023,
"color": "ROJO",
"placa": "K2520924",
"chasis": "LZBTX9C80P1000338",
"direccion": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 VIEJO ARROYO HONDO SANTO DOMINGO DE GUZMAN",
"estatus": "ACTIVO",
"valor_fidegnido": "No Disponible"
},
{
"marca": "TOYOTA",
"modelo": "LAND CRUISER 300 VXR 4WD",
"ano": 2025,
"color": "NEGRO",
"placa": "Z008531",
"chasis": "JTMAA7BJ2R4086837",
"direccion": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 VIEJO ARROYO HONDO SANTO DOMINGO DE GUZMAN",
"estatus": "VEHICULO TIENE OPOSICION",
"valor_fidegnido": "No Disponible"
},
{
"marca": "LAND ROVER",
"modelo": "RANGE ROVER SPORT SVR 4X4",
"ano": 2019,
"color": "NEGRO",
"placa": "Z007118",
"chasis": "SALWZ2SE3KA873221",
"direccion": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 VIEJO ARROYO HONDO SANTO DOMINGO DE GUZMAN",
"estatus": "VEHICULO TIENE OPOSICION",
"valor_fidegnido": "No Disponible"
},
{
"marca": "KIA",
"modelo": "PICANTO",
"ano": 2018,
"color": "AZUL",
"placa": "A823647",
"chasis": "KNAB2511BJT197249",
"direccion": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 VIEJO ARROYO HONDO SANTO DOMINGO DE GUZMAN",
"estatus": "ACTIVO",
"valor_fidegnido": "347,980.00"
},
{
"marca": "LINCOLN",
"modelo": "LINCOLN NAVIGATOR",
"ano": 2016,
"color": "NEGRO",
"placa": "X245233",
"chasis": "5LMJJ2JT4GBL05996",
"direccion": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 VIEJO ARROYO HONDO, SANTO DOMINGO DE GUZMAN",
"estatus": "ACTIVO",
"valor_fidegnido": "No Disponible"
}
],
"telefonos": [
{
"telefono": "8095924066",
"fecha_creacion": "2022-12-26",
"tipo": "LOCAL"
},
{
"telefono": "8297281469",
"fecha_creacion": "2021-07-17",
"tipo": "CELULAR ALTICE"
},
{
"telefono": "8094834807",
"fecha_creacion": "2023-05-05",
"tipo": "LOCAL"
},
{
"telefono": "8098493247",
"fecha_creacion": "2021-04-26",
"tipo": "CELULAR ALTICE"
},
{
"telefono": "8098828234",
"fecha_creacion": "2022-04-25",
"tipo": "CELULAR ALTICE"
},
{
"telefono": "8099948234",
"fecha_creacion": "2021-09-05",
"tipo": "CELULAR ALTICE"
},
{
"telefono": "8092589292",
"fecha_creacion": "2022-09-06",
"tipo": "CELULAR CLARO"
},
{
"telefono": "8092714417",
"fecha_creacion": "2023-09-26",
"tipo": "CELULAR CLARO"
},
{
"telefono": "8096972004",
"fecha_creacion": "2021-05-22",
"tipo": "CELULAR CLARO"
},
{
"telefono": "8095662221",
"fecha_creacion": "2022-12-21",
"tipo": "LOCAL"
},
{
"telefono": "8094831950",
"fecha_creacion": "2023-03-14",
"tipo": "LOCAL"
},
{
"telefono": "8094830215",
"fecha_creacion": "2022-12-06",
"tipo": "LOCAL"
},
{
"telefono": "8095651469",
"fecha_creacion": "2023-08-28",
"tipo": "LOCAL"
},
{
"telefono": "8092225203",
"fecha_creacion": "2022-02-13",
"tipo": "CELULAR CLARO"
},
{
"telefono": "8099835778",
"fecha_creacion": "2024-04-19",
"tipo": "CELULAR ALTICE"
},
{
"telefono": "8096318897",
"fecha_creacion": "2024-06-20",
"tipo": "CELULAR ALTICE"
},
{
"telefono": "8097281469",
"fecha_creacion": "2024-09-10",
"tipo": "LOCAL"
},
{
"telefono": "8098196526",
"fecha_creacion": "2025-04-15",
"tipo": "CELULAR ALTICE"
}
],
"direcciones": [
{
"calle": "MANZANA F   ",
"numero": "17",
"provincia": "DISTRITO NACIONAL",
"municipio": null,
"sector": "AMINA",
"ciudad": "SANTO DOMINGO",
"fecha_creacion": "2023-06-29"
},
{
"calle": "MANZANA F   ",
"numero": "17",
"provincia": "DESCONOCIDO",
"municipio": null,
"sector": "AMINA",
"ciudad": null,
"fecha_creacion": "2022-04-18"
},
{
"calle": "MANZANA F # 17 ",
"numero": "",
"provincia": "DESCONOCIDO",
"municipio": null,
"sector": "EL AGUACATE AFUERA",
"ciudad": null,
"fecha_creacion": "2022-02-11"
},
{
"calle": "MANZANA F, #17",
"numero": "17",
"provincia": "SANTO DOMINGO",
"municipio": "Santo Domingo Este",
"sector": "Cancino Adentro",
"ciudad": null,
"fecha_creacion": "2023-04-11"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2022-02-09"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2021-03-29"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2021-01-06"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO, SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2021-12-08"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2023-04-16"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2023-05-22"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO, SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2023-04-21"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2023-11-28"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2023-11-28"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO, SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2023-11-28"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2023-12-28"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2023-12-28"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO, SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2023-12-28"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO DISTRITO NACIONAL                                                                                                                                                                                     ",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO, SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-01-12"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-08-02"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-08-02"
},
{
"calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 ARROYO HONDO VIEJO, SANTO DOMINGO DE GUZMAN",
"numero": null,
"provincia": null,
"municipio": null,
"sector": null,
"ciudad": null,
"fecha_creacion": "2024-08-02"
}
],
"tiene_inmueble": "no",
"tiene_orden_arresto": "no",
"tiene_contador": "no",
"armas": [],
"total_valor_vehiculos": "347980.00"
}';

// Si no hay JSON definido, usar datos de ejemplo
if (empty($json)) {
    $json = '{
      "nombre": "BOLIVAR ERNESTO VALERA ARIZA",
      "cedula": "00114935240",
      "profesion": "ARTISTA",
      "estado_civil": "S",
      "sexo": "M",
      "fecha_nacimiento": "1981-06-20",
      "edad": 43,
      "nacionalidad": "DOMINICANA",
      "correo": "felix.jeiren.jeileen@gmail.com",
      "gestion": "si",
      "repeticiones": 2,
      "empleos": [
        {
          "rnc_empleador": "130969957",
          "nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
          "salario": "100000.00",
          "periodo": "2022-08-01"
        },
        {
          "rnc_empleador": "130969957",
          "nombre_empleador": "DOMINICAN DREAM AGENCY SRL",
          "salario": "105000.00",
          "periodo": "2025-04-01"
        },
        {
          "rnc_empleador": "401007606",
          "nombre_empleador": "CÁMARA DE DIPUTADOS DE LA REPÚBLICA",
          "salario": "368000.00",
          "periodo": "2022-08-01"
        },
        {
          "rnc_empleador": "401007606",
          "nombre_empleador": "CÁMARA DE DIPUTADOS DE LA REPÚBLICA",
          "salario": "380000.00",
          "periodo": "2025-04-01"
        }
      ],
      "relaciones": [
        {
          "cedula": "40205298124",
          "nombre": "BOLIVAR ANDRES VALERA PICHARDO",
          "relacion": "Hijo",
          "telefono": "+1 (829)113-4021",
          "foto": "IMAGEN_BASE64"
        },
        {
          "cedula": "40245595729",
          "nombre": "ISABEL MERCEDES VALERA GAUTREAU",
          "relacion": "Hija",
          "telefono": "+1 (809)333-2907",
          "foto": "IMAGEN_BASE64"
        },
        {
          "cedula": "00102822418",
          "nombre": "ROSA ISABEL ARIZA MEDRANO",
          "relacion": "Posible Relación",
          "telefono": "+1 (829)132-7926",
          "foto": "IMAGEN_BASE64"
        }
      ],
      "vehiculos": [
        {
          "marca": "GACELA",
          "modelo": "BULLET 150",
          "ano": 2023,
          "color": "ROJO",
          "placa": "K2520924",
          "chasis": "LZBTX9C80P1000338",
          "direccion": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 VIEJO ARROYO HONDO",
          "estatus": "ACTIVO",
          "valor_fidegnido": ""
        },
        {
          "marca": "TOYOTA",
          "modelo": "LAND CRUISER 300 VXR 4WD",
          "ano": 2025,
          "color": "NEGRO",
          "placa": "Z008531",
          "chasis": "JTMAA7BJ2R4086837",
          "direccion": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 VIEJO ARROYO HONDO",
          "estatus": "VEHICULO TIENE OPOSICION",
          "valor_fidegnido": ""
        },
        {
          "marca": "LAND ROVER",
          "modelo": "RANGE ROVER SPORT SVR 4X4",
          "ano": 2019,
          "color": "NEGRO",
          "placa": "Z007118",
          "chasis": "SALWZ2SE3KA873221",
          "direccion": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 VIEJO ARROYO HONDO",
          "estatus": "VEHICULO TIENE OPOSICION",
          "valor_fidegnido": ""
        },
        {
          "marca": "KIA",
          "modelo": "PICANTO",
          "ano": 2018,
          "color": "AZUL",
          "placa": "A823647",
          "chasis": "KNAB2511BJT197249",
          "direccion": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 VIEJO ARROYO HONDO",
          "estatus": "ACTIVO",
          "valor_fidegnido": "347980.00"
        },
        {
          "marca": "LINCOLN",
          "modelo": "NAVIGATOR",
          "ano": 2016,
          "color": "NEGRO",
          "placa": "X245233",
          "chasis": "5LMJJ2JT4GBL05996",
          "direccion": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4 VIEJO ARROYO HONDO",
          "estatus": "ACTIVO",
          "valor_fidegnido": ""
        }
      ],
      "telefonos": [
        {
          "telefono": "809-271-4417",
          "fecha_creacion": "2023-09-26",
          "tipo": "CELULAR CLARO"
        },
        {
          "telefono": "809-483-4807",
          "fecha_creacion": "2023-05-05",
          "tipo": "LOCAL"
        },
        {
          "telefono": "809-592-4066",
          "fecha_creacion": "2022-12-26",
          "tipo": "LOCAL"
        },
        {
          "telefono": "809-258-9292",
          "fecha_creacion": "2022-09-06",
          "tipo": "CELULAR CLARO"
        },
        {
          "telefono": "809-882-8234",
          "fecha_creacion": "2022-04-25",
          "tipo": "CELULAR ALTICE"
        },
        {
          "telefono": "809-994-8234",
          "fecha_creacion": "2021-09-05",
          "tipo": "CELULAR ALTICE"
        },
        {
          "telefono": "829-728-1469",
          "fecha_creacion": "2021-07-17",
          "tipo": "CELULAR ALTICE"
        },
        {
          "telefono": "809-849-3247",
          "fecha_creacion": "2021-04-26",
          "tipo": "CELULAR ALTICE"
        }
      ],
      "direcciones": [
        {
          "calle": "MANZANA F #17, AMINA",
          "provincia": "DISTRITO NACIONAL",
          "municipio": "SANTO DOMINGO",
          "fecha_creacion": "2023-06-29"
        },
        {
          "calle": "SOL PONIENTE D4 EDIF MADRIGAL APTO D4",
          "provincia": "ARROYO HONDO VIEJO",
          "municipio": "SANTO DOMINGO",
          "fecha_creacion": "2021-01-06"
        }
      ],
      "inmuebles": [
        {
          "tipo": "Apartamento",
          "ubicacion": "Arroyo Hondo",
          "direccion": "Sol Poniente D4, Edif. Madrigal Apto D4",
          "valor": "8500000.00",
          "tamano": "120"
        },
        {
          "tipo": "Terreno",
          "ubicacion": "Cancino Adentro",
          "direccion": "Manzana F #17, Santo Domingo Este",
          "valor": "2800000.00",
          "tamano": "800"
        },
        {
          "tipo": "Casa",
          "ubicacion": "Los Cacicazgos",
          "direccion": "Calle Pedro Henríquez Ureña #45",
          "valor": "12300000.00",
          "tamano": "280"
        },
        {
          "tipo": "Villa",
          "ubicacion": "Cap Cana",
          "direccion": "Residencial Marina, Villa #23",
          "valor": "22800000.00",
          "tamano": "450"
        }
      ],
      "tiene_orden_arresto": "no",
      "tiene_contador": "no",
      "tiene_inmueble": "si",
      "armas": [],
      "total_valor_vehiculos": "347980.00"
    }';
}

// Función para filtrar datos duplicados
function filtrarDatos($jsonString) {
    $data = json_decode($jsonString, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [];
    }

    // Filtrar empleos: solo primero y último por RNC
    if (isset($data['empleos'])) {
        $porRnc = [];

        foreach ($data['empleos'] as $empleo) {
            $rnc = $empleo['rnc_empleador'];
            $porRnc[$rnc][] = $empleo;
        }

        $empleosFiltrados = [];
        foreach ($porRnc as $empleos) {
            usort($empleos, function($a, $b) {
                return strtotime($a['periodo']) <=> strtotime($b['periodo']);
            });
            $primero = reset($empleos);
            $ultimo = end($empleos);
            $empleosFiltrados[] = $primero;
            if ($primero !== $ultimo) $empleosFiltrados[] = $ultimo;
        }

        $data['empleos'] = $empleosFiltrados;
    }

// Filtrar direcciones similares usando el campo 'calle'
if (isset($data['direcciones'])) {
    $filtradas = [];
    
    foreach ($data['direcciones'] as $dir) {
        // Limpiar espacios en blanco extra de la calle actual
        $calleActual = trim(preg_replace('/\s+/', ' ', $dir['calle']));
        $esUnica = true;
        
        foreach ($filtradas as $dirFiltrada) {
            // Limpiar espacios en blanco extra de la calle filtrada
            $calleFiltrada = trim(preg_replace('/\s+/', ' ', $dirFiltrada['calle']));
            
            // Evitar división por cero
            $maxLength = max(strlen($calleActual), strlen($calleFiltrada));
            if ($maxLength > 0) {
                // Comparar por similitud (85% similar se considera duplicada)
                $similitud = similar_text($calleActual, $calleFiltrada) / $maxLength;
                if ($similitud > 0.85) {
                    $esUnica = false;
                    break;
                }
            }
        }
        
        if ($esUnica) {
            $filtradas[] = $dir;
        }
    }
    
    $data['direcciones'] = $filtradas;
}

    return $data;
}

// Función para formatear fechas (de YYYY-MM-DD a DD/MM/YYYY)
function formatearFecha($fecha) {
    if (empty($fecha)) return 'N/A';
    
    // Determinar formato de entrada
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
        // Formato YYYY-MM-DD
        $partes = explode('-', $fecha);
        return "{$partes[2]}/{$partes[1]}/{$partes[0]}";
    } elseif (preg_match('/^\d{2}-\d{2}-\d{4}$/', $fecha)) {
        // Formato DD-MM-YYYY
        $partes = explode('-', $fecha);
        return "{$partes[0]}/{$partes[1]}/{$partes[2]}";
    }
    
    return $fecha;
}

// Función para formatear montos en formato RD$
function formatearMonto($monto) {
    if ($monto == '0.00') return 'RD$ 0.00';
    if(empty($monto)) return 'No Encontrado';
    
    $monto = str_replace(',', '', $monto);
    return 'RD$ ' . number_format((float)$monto, 2, '.', ',');
}

// Formatear el estado civil
function formatearEstadoCivil($codigo) {
    $estados = [
        'S' => 'Soltero/a',
        'C' => 'Casado/a',
        'D' => 'Divorciado/a',
        'V' => 'Viudo/a'
    ];
    
    return isset($estados[$codigo]) ? $estados[$codigo] : $codigo;
}

// Formatear el sexo
function formatearSexo($codigo) {
    $sexos = [
        'M' => 'Masculino',
        'F' => 'Femenino'
    ];
    
    return isset($sexos[$codigo]) ? $sexos[$codigo] : $codigo;
}

// Función para obtener el logo de compañía telefónica
function obtenerLogoTelefono($tipo) {
    $tipo = strtoupper($tipo);
    
    if (strpos($tipo, 'CLARO') !== false) {
        return '<img class="phone-logo" src="assets/logo-claro.png" alt="Claro">';
    } elseif (strpos($tipo, 'ALTICE') !== false) {
        return '<img class="phone-logo" src="assets/logo-altice.png" alt="Altice">';
    } else {
        return '<i class="fas fa-phone-alt phone-logo"></i>';
    }
}

// Función para obtener clase de valor de inmuebles
function obtenerClaseValor($valor) {
    $valor = (float)str_replace(',', '', $valor);
    
    if ($valor >= 20000000) return 'value-ultra-high';
    if ($valor >= 10000000) return 'value-high';
    if ($valor >= 5000000) return 'value-medium';
    return 'value-low';
}

// Función para calcular índice de fiabilidad
function calcularFiabilidad($datos) {
    $puntos = 50; // Base
    
    // Puntos por factores positivos
    if (strtolower($datos['gestion'] ?? '') === 'si') $puntos += 20;
    if (!empty($datos['empleos'])) $puntos += 10;
    if (strtolower($datos['tiene_inmueble'] ?? '') === 'si') $puntos += 15;
    
    // Puntos negativos por factores de riesgo
    if (strtolower($datos['tiene_orden_arresto'] ?? '') === 'si') $puntos -= 30;
    if (($datos['repeticiones'] ?? 0) > 5) $puntos -= 10;
    
    // Verificar si tiene armas (factor de riesgo alto)
    if (isset($datos['armas']) && !empty($datos['armas'])) $puntos -= 25;
    
    return max(10, min(100, $puntos));
}

// Procesar los datos
$datos = filtrarDatos($json);

// Ordenar teléfonos por fecha (más reciente primero)
if (isset($datos['telefonos'])) {
    usort($datos['telefonos'], function($a, $b) {
        return strtotime($b['fecha_creacion']) - strtotime($a['fecha_creacion']);
    });
}

// Agrupar empleos por RNC
$empleosPorRNC = [];
if (isset($datos['empleos'])) {
    foreach ($datos['empleos'] as $empleo) {
        $rnc = $empleo['rnc_empleador'];
        
        // Verificar si nombre_empleador está vacío y asignar "no encontrado"
        $nombre_empleador = (!empty($empleo['nombre_empleador'])) 
            ? $empleo['nombre_empleador'] 
            : 'No Encontrado';
        
        if (!isset($empleosPorRNC[$rnc])) {
            $empleosPorRNC[$rnc] = [
                'nombre_empleador' => $nombre_empleador,
                'empleos' => []
            ];
        }
        $empleosPorRNC[$rnc]['empleos'][] = $empleo;
    }
}

$fiabilidad = calcularFiabilidad($datos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Personal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            font-size: 0.85rem;
            margin: 0;
            padding: 0;
        }
        
        .page {
            width: 8.5in;
            min-height: 11in;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            position: relative;
            padding-bottom: 4rem;
        }
        
        /* Tarjeta de información personal ultra compacta */
        .personal-card {
           border-radius: 10px;
           background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 50%, #e9ecef 100%);
           border: 1px solid #dee2e6;
           padding: 1rem;
           margin-bottom: 1rem;
           box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
           position: relative;
        }

        .personal-card h2 {
           font-size: 1.1rem;
           font-weight: 700;
           margin-bottom: 0.6rem;
           color: #212529;
           text-transform: uppercase;
           letter-spacing: 1px;
           border-bottom: 2px solid #0d6efd;
           padding-bottom: 0.2rem;
           display: inline-block;
        }

        .profile-section {
           display: flex;
           align-items: flex-start;
           gap: 0.8rem;
        }

        .profile-img {
           width: 110px;
           height: 110px;
           border-radius: 8px;
           background: linear-gradient(135deg, #0d6efd, #6610f2);
           display: flex;
           align-items: center;
           justify-content: center;
           color: white;
           font-size: 1.2rem;
           flex-shrink: 0;
           box-shadow: 0 3px 8px rgba(13, 110, 253, 0.3);
           border: 2px solid white;
           overflow: hidden;
        }

        .profile-img img {
           width: 100%;
           height: 100%;
           object-fit: cover;
           object-position: center;
           border-radius: 6px;
        }

        .profile-info {
           flex: 1;
           margin-right: 160px;
        }

        .info-grid {
           display: grid;
           grid-template-columns: 1fr 1fr 1fr;
           gap: 0.4rem 1.2rem;
           margin-top: 0.2rem;
        }

        .info-item {
           background: rgba(255, 255, 255, 0.7);
           padding: 0.35rem 0.6rem;
           border-radius: 5px;
           border-left: 2px solid #0d6efd;
           transition: all 0.3s ease;
        }

        .info-item:hover {
           background: rgba(255, 255, 255, 0.9);
           transform: translateY(-1px);
           box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
        }

        .info-label {
           color: #6c757d;
           font-weight: 600;
           font-size: 0.6rem;
           text-transform: uppercase;
           letter-spacing: 1px;
           margin-bottom: 0.1rem;
           display: block;
           line-height: 1;
           margin-top: 5px;
        }

        .info-value {
           color: #212529;
           font-weight: 600;
           font-size: 0.7rem;
           display: block;
           line-height: 1.1;
        }

        /* Indicador de fiabilidad con forma de goniómetro */
        .reliability-section {
           position: absolute;
           top: 1.5rem;
           right: 1.5rem;
           width: 140px;
           background: rgba(255, 255, 255, 0.95);
           border-radius: 8px;
           padding: 0.6rem;
           box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
           border: 1px solid #e9ecef;
        }

        .reliability-title {
           font-size: 0.65rem;
           font-weight: 700;
           margin-bottom: 0.4rem;
           color: #212529;
           text-align: center;
           text-transform: uppercase;
           letter-spacing: 0.5px;
        }

        /* Goniómetro circular */
        .reliability-meter {
           position: relative;
           width: 80px;
           height: 40px;
           margin: 0 auto 0.5rem;
           overflow: hidden;
        }

        .reliability-meter::before {
           content: '';
           position: absolute;
           width: 80px;
           height: 80px;
           border: 4px solid #e9ecef;
           border-radius: 50%;
           top: 0;
           left: 0;
        }

        .reliability-bar {
           position: absolute;
           width: 80px;
           height: 80px;
           border-radius: 50%;
           border: 4px solid transparent;
           border-top: 4px solid #dc3545;
           border-right: 4px solid #ffc107;
           border-bottom: 4px solid #198754;
           transform: rotate(-90deg);
           top: 0;
           left: 0;
        }

        /* Aguja indicadora */
        .reliability-needle {
           position: absolute;
           width: 2px;
           height: 30px;
           background: #212529;
           top: 5px;
           left: 50%;
           transform-origin: bottom center;
           transform: translateX(-50%) rotate(<?php echo ($fiabilidad * 0.9); ?>deg);
           border-radius: 1px;
           box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
        }

        .reliability-needle::after {
           content: '';
           position: absolute;
           width: 8px;
           height: 8px;
           background: #212529;
           border: 2px solid white;
           border-radius: 50%;
           bottom: -4px;
           left: -3px;
           box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

.reliability-meter {
    position: relative;
}


.reliability-percentage {
    position: absolute;
    top: 30%; /* Cambia este valor para mover más arriba o abajo */
    left: 50%;
    transform: translate(-50%, -50%);
    /* resto del CSS igual */
}

.reliability-percentage {
    position: absolute;
    top: 25%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 14px;
    font-weight: bold;
    color: #2c3e50;
    text-shadow: 1px 1px 2px rgba(255,255,255,0.8);
    z-index: 15;
    margin-top: 6px;
    margin-left: 3px;
}

        .risk-indicators {
           display: flex;
           gap: 0.25rem;
           margin-bottom: 0.5rem;
           justify-content: center;
        }

        .risk-icon, .good-icon {
           width: 20px;
           height: 20px;
           border-radius: 50%;
           display: flex;
           align-items: center;
           justify-content: center;
           font-size: 0.65rem;
        }

        .risk-icon {
           background-color: rgba(220, 53, 69, 0.15);
           color: #dc3545;
        }

        .good-icon {
           background-color: rgba(53, 220, 81, 0.15);
           color: #1bc005;
        }

        /* Secciones de información */
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 1rem;
            padding-bottom: 0.4rem;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Tarjetas de información simplificada */
        .simple-card {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 0.8rem;
            margin-bottom: 0.6rem;
            border-left: 4px solid #6c757d;
            transition: transform 0.2s ease;
        }
        
        .simple-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .phone-card { border-left-color: #0d6efd; }
        .address-card { border-left-color: #6c757d; }
        .relation-card { border-left-color: #6610f2; }
        .employment-card { border-left-color: #198754; }
        .property-card { border-left-color: #20c997; }
        .vehicle-card { border-left-color: #fd7e14; }

        .phone-logo {
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
        }

        /* Tarjetas de inmuebles */
        .property-card {
            position: relative;
            padding: 0.8rem 0.8rem 0.8rem 1rem;
            border-left-color: #20c997;
            min-height: 85px;
        }

        .property-value-badge {
            position: absolute;
            top: 0.6rem;
            right: 0.6rem;
            font-size: 0.65rem;
            padding: 0.3rem 0.6rem;
            border-radius: 12px;
            font-weight: 700;
            white-space: nowrap;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .value-low { background-color: #ffc107; color: #000; }
        .value-medium { background-color: #fd7e14; color: white; }
        .value-high { background-color: #dc3545; color: white; }
        .value-ultra-high { background-color: #6f42c1; color: white; }

        .property-title {
            font-weight: 700;
            color: #343a40;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
            margin-right: 4rem;
            line-height: 1.2;
        }

        .property-details {
            font-size: 0.75rem;
            color: #6c757d;
            line-height: 1.3;
            margin-bottom: 0.3rem;
        }

        .property-size {
            font-size: 0.7rem;
            color: #495057;
            margin: 0;
            font-weight: 600;
        }

        /* Tarjetas de vehículos */
        .vehicle-card {
           position: relative;
           padding: 0.8rem;
           border-left-color: #fd7e14;
           min-height: 110px;
           padding-bottom: 2.5rem;
        }

        .vehicle-header {
           width: 100%;
           margin-bottom: 0.5rem;
        }

        .vehicle-title {
           font-weight: 700;
           color: #343a40;
           font-size: 0.85rem;
           line-height: 1.2;
           width: 100%;
           margin: 0;
        }

        .vehicle-details {
           font-size: 0.7rem;
           color: #6c757d;
           line-height: 1.4;
        }

        .vehicle-details div {
           margin-bottom: 0.2rem;
        }

        .vehicle-details div:last-child {
           margin-bottom: 0;
        }

        .vehicle-status-badge {
           position: absolute;
           bottom: 0.5rem;
           left: 0.6rem;
        }

        .vehicle-value-badge {
           position: absolute;
           bottom: 0.5rem;
           right: 0.6rem;
           font-size: 0.55rem;
           padding: 0.3rem 0.6rem;
           border-radius: 12px;
           font-weight: 700;
           white-space: nowrap;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
           background-color: #6f42c1;
           color: white !important;
        }

        .non-value {
            background-color: #495057;
        }
        
        /* Tarjetas de empleo */
        .employment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.3rem;
        }
        
        .employment-title {
            font-weight: 600;
            color: #343a40;
            font-size: 0.85rem;
            flex: 1;
        }
        
        .employment-period {
            color: #6c757d;
            font-size: 0.65rem;
            white-space: nowrap;
            letter-spacing: -0.5px;
        }
        
        .employment-details {
            display: flex;
            justify-content: space-between;
            font-size: 0.7rem;
            color: #6c757d;
        }
        
        /* Tarjetas de relaciones */
        .relation-card {
           display: flex;
           flex-direction: column;
           padding: 0.8rem;
           gap: 0.5rem;
        }

        .relation-header {
           width: 100%;
           margin-bottom: 0.3rem;
        }

        .relation-name {
           font-weight: 700;
           font-size: 0.8rem;
           color: #212529;
           line-height: 1.2;
           margin: 0;
        }

        .relation-body {
           display: flex;
           gap: 0.8rem;
           align-items: flex-start;
        }

        .relation-img {
           width: 50px;
           height: 50px;
           border-radius: 50%;
           background: linear-gradient(135deg, #6610f2, #8e44ad);
           display: flex;
           align-items: center;
           justify-content: center;
           color: white;
           font-size: 1.2rem;
           box-shadow: 0 2px 6px rgba(102, 16, 242, 0.3);
           flex-shrink: 0;
           overflow: hidden;
        }

        .relation-img img {
           width: 100%;
           height: 100%;
           object-fit: cover;
           object-position: center;
           border-radius: 50%;
        }

        .relation-info {
           flex: 1;
        }

        .relation-contact-line {
           font-size: 0.7rem;
           color: #495057;
           margin-bottom: 0.3rem;
           line-height: 1.2;
        }

        .relation-contact-line i {
           color: #6c757d;
           margin-right: 0.3rem;
        }

        .relation-type {
           font-size: 0.65rem;
           color: #6c757d;
           margin: 0;
           font-weight: 600;
           text-transform: uppercase;
           letter-spacing: 0.3px;
        }

        /* Pie de página */
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem 1.5rem;
            font-size: 0.7rem;
            color: #6c757d;
            text-align: center;
            border-top: 1px solid #e9ecef;
            background-color: #f8f9fa;
            margin: 0;
        }

        /* Configuración para impresión */
        @media print {
           * {
               -webkit-print-color-adjust: exact !important;
               color-adjust: exact !important;
               print-color-adjust: exact !important;
           }
           
           body {
               background-color: white !important;
               margin: 0 !important;
               padding: 0 !important;
               font-size: 0.85rem !important;
           }
           
           .page {
               width: 100% !important;
               max-width: none !important;
               box-shadow: none !important;
               margin: 0 !important;
               padding: 1rem !important;
               min-height: auto !important;
               padding-bottom: 3rem !important;
               page-break-inside: avoid;
           }
           
           .d-print-none {
               display: none !important;
           }
           
           .col-md-3 { width: 25% !important; float: left; }
           .col-md-4 { width: 33.33333% !important; float: left; }
           .col-md-6 { width: 50% !important; float: left; }
           
           .row {
               display: flex !important;
               flex-wrap: wrap !important;
               margin: 0 !important;
           }
           
           .row.g-2 > *, .row.g-3 > * {
               padding: 0.25rem !important;
           }
           
           .personal-card {
               background: none !important;
               background-color: white !important;
               border: 1px solid #dee2e6 !important;
               border-radius: 10px !important;
               box-shadow: none;
           }
           
           .simple-card {
               background-color: white !important;
               border: 1px solid #e9ecef !important;
               border-radius: 6px !important;
           }
           
           .phone-card,.address-card,.relation-card,.employment-card,.property-card,.vehicle-card {
                border-left: 4px solid grey !important; 
            }
           
           .reliability-section {
               background-color: white !important;
               border: 1px solid #e9ecef !important;
           }
           
           .reliability-meter::before {
               border: 4px solid #e9ecef !important;
           }
           
           .reliability-bar {
               border-top: 4px solid #dc3545 !important;
               border-right: 4px solid #ffc107 !important;
               border-bottom: 4px solid #198754 !important;
           }
           
           .reliability-needle {
               background: #212529 !important;
           }
           
           .reliability-needle::after {
               background: #212529 !important;
               border: 2px solid white !important;
           }
           
           .badge.bg-success {
               background-color: #198754 !important;
               color: white !important;
           }
           
           .badge.bg-warning {
               background-color: #ffc107 !important;
               color: #000 !important;
           }
           
           .property-value-badge, .vehicle-value-badge {
               box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2) !important;
           }
           
           .value-low {
               background-color: #ffc107 !important;
               color: #000 !important;
           }
           
           .value-medium {
               background-color: #fd7e14 !important;
               color: white !important;
           }
           
           .value-high {
               background-color: #dc3545 !important;
               color: white !important;
           }
           
           .value-ultra-high {
               background-color: #6f42c1 !important;
               color: white !important;
           }
           
           .risk-icon {
               background-color: rgba(220, 53, 69, 0.15) !important;
               color: #dc3545 !important;
           }
           
           .good-icon {
               background-color: rgba(53, 220, 81, 0.15) !important;
               color: #1bc005 !important;
           }
           
           .info-item {
               background: rgba(255, 255, 255, 0.7) !important;
               border-left: 2px solid #0d6efd !important;
           }
           
           .footer {
               position: relative !important;
               margin-top: 1rem !important;
               background-color: #f8f9fa !important;
               border-top: 1px solid #e9ecef !important;
           }
           
           .personal-card, .simple-card, .section-title, .dont-cut-print {
               page-break-inside: avoid !important;
               break-inside: avoid !important;
           }
           
           .mb-4 {
               margin-bottom: 1rem !important;
           }
           
           .section-title {
               border-bottom: 2px solid #e9ecef !important;
           }

           .relacionados-print .col-md-4 {
               width: 50% !important;
               float: left;
           }
           
           .relacionados-print .row {
               display: flex !important;
               flex-wrap: wrap !important;
           }
           
           .relacionados-print .simple-card {
               margin-bottom: 0.5rem !important;
           }

           * {
            box-shadow: none !important;
           }

            /* Secciones de información */
        .section-title {
            font-size: 0.8rem;
            margin-bottom: 0px;
            padding-bottom: 0.2rem;
        }
        
        /* Tarjetas de información simplificada */
        .simple-card {
            padding: 0.1rem;
            margin-bottom: 0.2rem;
            font-size: 10px !important;
            margin-bottom: -15px;
        }

        /* Tarjetas de vehículos */
        .vehicle-card {
            padding-bottom: 2rem;
        }

        .fa-phone-alt {
            margin-right: -5px;
        }

        .dont-cut-print {
            margin-bottom: 1px !important;
        }

        .section-title {
            margin-top: 15px;
        }

        .relation-name, .employment-title, .vehicle-title {
            font-size: 11px;
        }
        
        }

        @page {
           size: letter !important;
           margin: 0.5in !important;
        }
    </style>
</head>
<body>
    <!-- Botón de impresión -->
    <div class="container-fluid my-4 d-print-none">
        <div class="text-center mb-3">
            <button class="btn btn-primary btn-lg" onclick="window.print();">
                <i class="fas fa-print me-2"></i>Imprimir Reporte
            </button>
        </div>
    </div>

    <div class="page">

        <!-- Información Personal con Fiabilidad -->
        <div class="personal-card">
            <h2><?php echo htmlspecialchars($datos['nombre'] ?? 'Nombre no disponible'); ?></h2>
            <div class="d-flex justify-content-between">
                <div class="profile-section">
                    <div class="profile-img">
                        <?php if (!empty($datos['foto']) && $datos['foto'] !== 'IMAGEN_BASE64'): ?>
                        <img src="data:image/jpeg;base64,<?php echo $datos['foto']; ?>" alt="">
                        <?php else: ?>
                        <i class="fas fa-user"></i>
                        <?php endif; ?>
                    </div>
                    <div class="profile-info">
                        <div class="info-grid">
                            <div style="margin-left: 10px;">
                                <div class="info-row">
                                    <div class="info-label">Cédula:</div>
                                    <div class="info-value"><?php echo htmlspecialchars($datos['cedula'] ?? 'N/A'); ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Profesión:</div>
                                    <div class="info-value"><?php echo htmlspecialchars($datos['profesion'] ?? 'N/A'); ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Nacionalidad:</div>
                                    <div class="info-value"><?php echo htmlspecialchars($datos['nacionalidad'] ?? 'N/A'); ?></div>
                                </div>
                            </div>
                            <div>
                                <div class="info-row">
                                    <div class="info-label">Nacimiento:</div>
                                    <div class="info-value"><?php echo formatearFecha($datos['fecha_nacimiento'] ?? ''); ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Estado Civil:</div>
                                    <div class="info-value"><?php echo formatearEstadoCivil($datos['estado_civil'] ?? ''); ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Sexo:</div>
                                    <div class="info-value"><?php echo formatearSexo($datos['sexo'] ?? ''); ?></div>
                                </div>
                            </div>
                            <div>
                                <div class="info-row">
                                    <div class="info-label">Correo:</div>
                                    <div class="info-value"><?php echo htmlspecialchars($datos['correo'] ?? 'N/A'); ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Edad:</div>
                                    <div class="info-value"><?php echo htmlspecialchars($datos['edad'] ?? 'N/A'); ?> años</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sección de Fiabilidad -->
                <div class="reliability-section">
                    <div class="reliability-title">Índice de Fiabilidad</div>
                    <div class="reliability-meter">
                        <div class="reliability-bar"></div>
                        <div class="reliability-needle"></div>
                        <!-- Porcentaje arriba de la aguja -->
                        <div class="reliability-percentage">
                            <?php echo calcularFiabilidad($datos); ?>%
                        </div>
                    </div>
                    <div class="risk-indicators">
                        <?php 
                        // Solo mostrar si tiene orden de arresto
                        if (strtolower($datos['tiene_orden_arresto'] ?? '') === 'si'): 
                        ?>
                        <div class="risk-icon" title="Tiene orden de arresto">
                            <i class="fas fa-handcuffs"></i>
                        </div>
                        <?php endif; ?>

                        <?php 
                        // Solo mostrar si tiene vehículos con oposición
                        if (isset($datos['vehiculos']) && count($datos['vehiculos']) > 0):
                            $tieneOposicion = false;
                            foreach ($datos['vehiculos'] as $vehiculo) {
                                if (strpos(strtolower($vehiculo['estatus'] ?? ''), 'oposicion') !== false) {
                                    $tieneOposicion = true;
                                    break;
                                }
                            }
                            
                            if ($tieneOposicion): 
                        ?>
                        <div class="risk-icon" title="Vehículos con oposición">
                            <i class="fas fa-car"></i>
                        </div>
                        <?php 
                            endif;
                        endif; 
                        ?>

                        <?php 
                        // Solo mostrar si tiene armas
                        if (isset($datos['armas']) && !empty($datos['armas'])): 
                        ?>
                        <div class="risk-icon" title="Posee armas registradas (<?php echo count($datos['armas']); ?>)">
                            <i class="fas fa-crosshairs"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teléfonos -->
        <div class="mb-4 dont-cut-print">
            <h3 class="section-title">
                <i class="fas fa-phone-alt"></i>Teléfonos
            </h3>
            <div class="row g-2">
                <?php if (isset($datos['telefonos']) && count($datos['telefonos']) > 0): ?>
                    <?php foreach ($datos['telefonos'] as $telefono): ?>
                    <div class="col-md-3 printable-fix">
                        <div class="simple-card phone-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><strong><?php echo htmlspecialchars($telefono['telefono'] ?? ''); ?></strong></div>
                                <?php echo obtenerLogoTelefono($telefono['tipo'] ?? ''); ?>
                            </div>
                            <small class="text-muted"><?php echo formatearFecha($telefono['fecha_creacion'] ?? ''); ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p>No se encontraron teléfonos registrados.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Direcciones -->
        <div class="mb-4 dont-cut-print">
            <h3 class="section-title print-fix">
                <i class="fas fa-map-marker-alt"></i>Direcciones
            </h3>
            <div class="row g-2">
                <?php if (isset($datos['direcciones']) && count($datos['direcciones']) > 0): ?>
                    <?php foreach ($datos['direcciones'] as $direccion): ?>
                    <div class="col-md-6">
                        <div class="simple-card address-card">
                            <div><strong><?php echo htmlspecialchars($direccion['calle'] ?? ''); ?></strong></div>
                            <div class="d-flex justify-content-between">
                                <small><?php echo htmlspecialchars($direccion['provincia'] ?? ''); ?>, <?php echo htmlspecialchars($direccion['municipio'] ?? ''); ?></small>
                                <small>Desde: <?php echo formatearFecha($direccion['fecha_creacion'] ?? ''); ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p>No se encontraron direcciones registradas.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Relacionados -->
        <div class="mb-4 relacionados-print">
            <h3 class="section-title">
                <i class="fas fa-users"></i>Relacionados
            </h3>
            <div class="row g-2">
                <?php if (isset($datos['relaciones']) && count($datos['relaciones']) > 0): ?>
                    <?php foreach ($datos['relaciones'] as $relacion): ?>
                    <div class="col-md-6">
                        <div class="simple-card relation-card">
                            <div class="relation-header">
                                <p class="relation-name"><?php echo htmlspecialchars($relacion['nombre'] ?? 'N/A'); ?></p>
                            </div>
                            <div class="relation-body">
                                <div class="relation-img">
                                    <?php if (!empty($relacion['foto']) && $relacion['foto'] !== 'IMAGEN_BASE64'): ?>
                                    <img src="<?php echo htmlspecialchars($relacion['foto']); ?>" alt="">
                                    <?php else: ?>
                                    <i class="fas fa-user"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="relation-info">
                                    <div class="relation-contact-line">
                                        <i class="fas fa-id-card"></i><?php echo htmlspecialchars($relacion['cedula'] ?? 'N/A'); ?> | <i class="fas fa-phone-alt"></i><?php echo htmlspecialchars($relacion['telefono'] ?? 'N/A'); ?>
                                    </div>
                                    <p class="relation-type"><?php echo htmlspecialchars($relacion['relacion'] ?? 'N/A'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p>No se encontraron relaciones registradas.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Experiencia Laboral -->
        <div class="mb-4 dont-cut-print">
            <h3 class="section-title">
                <i class="fas fa-briefcase"></i>Experiencia Laboral
            </h3>
            <div class="row g-2">
                <?php if (count($empleosPorRNC) > 0): ?>
                    <?php foreach ($empleosPorRNC as $rnc => $grupo): ?>
                    <div class="col-md-6">
                        <div class="simple-card employment-card">
                            <div class="employment-header">
                                <div class="employment-title"><?php echo htmlspecialchars($grupo['nombre_empleador']); ?></div>
                                <div class="employment-period">RNC: <?php echo htmlspecialchars($rnc); ?></div>
                            </div>
                            <div class="employment-details">
                                <div>
                                    <?php 
                                    $primerEmpleo = reset($grupo['empleos']);
                                    $ultimoEmpleo = end($grupo['empleos']);
                                    
                                    if ($primerEmpleo === $ultimoEmpleo) {
                                        echo formatearFecha($primerEmpleo['periodo'] ?? '');
                                    } else {
                                        echo formatearFecha($primerEmpleo['periodo'] ?? '') . ' - ' . formatearFecha($ultimoEmpleo['periodo'] ?? '');
                                    }
                                    ?>
                                </div>
                                <div>Salario: <?php echo formatearMonto($ultimoEmpleo['salario'] ?? '0.00'); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p>No se encontraron registros de empleo.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Inmuebles -->
        <div class="mb-4 dont-cut-print">
           <h3 class="section-title">
               <i class="fas fa-home"></i>Inmuebles
           </h3>
           <div class="row g-2">
               <?php if (isset($datos['inmuebles']) && count($datos['inmuebles']) > 0): ?>
                   <?php foreach ($datos['inmuebles'] as $inmueble): ?>
                   <div class="col-md-6">
                       <div class="simple-card property-card">
                           <span class="property-value-badge <?php echo obtenerClaseValor($inmueble['valor'] ?? '0'); ?>">RD$ <?php echo number_format((float)str_replace(',', '', $inmueble['valor'] ?? '0') / 1000000, 1); ?>M</span>
                           <div class="property-title"><?php echo htmlspecialchars($inmueble['tipo'] ?? ''); ?> - <?php echo htmlspecialchars($inmueble['ubicacion'] ?? ''); ?></div>
                           <div class="property-details"><?php echo htmlspecialchars($inmueble['direccion'] ?? ''); ?></div>
                           <div class="property-size"><?php echo htmlspecialchars($inmueble['tamano'] ?? ''); ?> m²</div>
                       </div>
                   </div>
                   <?php endforeach; ?>
               <?php else: ?>
                   <div class="col-12">
                       <p>No se encontraron inmuebles registrados.</p>
                   </div>
               <?php endif; ?>
           </div>
        </div>

        <!-- Vehículos -->
        <div class="mb-4 dont-cut-print">
            <h3 class="section-title">
                <i class="fas fa-car"></i>Vehículos (Valor Total: <?php echo formatearMonto($datos['total_valor_vehiculos'] ?? '0.00'); ?>)
            </h3>
            <div class="row g-3">
                <?php if (isset($datos['vehiculos']) && count($datos['vehiculos']) > 0): ?>
                    <?php foreach ($datos['vehiculos'] as $vehiculo): ?>
                    <div class="col-md-6">
                        <div class="simple-card vehicle-card">
                            <div class="vehicle-header">
                                <div class="vehicle-title"><?php echo htmlspecialchars($vehiculo['marca'] ?? ''); ?> <?php echo htmlspecialchars($vehiculo['modelo'] ?? ''); ?> (<?php echo htmlspecialchars($vehiculo['ano'] ?? ''); ?>)</div>
                            </div>
                            <div class="vehicle-details">
                                <div><strong>PLACA:</strong> <?php echo htmlspecialchars($vehiculo['placa'] ?? ''); ?> | <strong>Color:</strong> <?php echo htmlspecialchars($vehiculo['color'] ?? ''); ?></div>
                                <div><strong>CHASIS:</strong> <?php echo htmlspecialchars($vehiculo['chasis'] ?? ''); ?></div>
                                <div><strong>DIRECCIÓN:</strong> <?php echo htmlspecialchars($vehiculo['direccion'] ?? ''); ?></div>
                            </div>
                            <span class="badge <?php echo strpos(strtolower($vehiculo['estatus'] ?? ''), 'oposicion') !== false ? 'bg-warning text-dark' : 'bg-success'; ?> vehicle-status-badge">
                                <?php echo strpos(strtolower($vehiculo['estatus'] ?? ''), 'oposicion') !== false ? 'OPOSICIÓN' : 'ACTIVO'; ?>
                            </span>
                            <span class="vehicle-value-badge <?php echo empty($vehiculo['valor_fidegnido']) ? 'non-value' : ''; ?>">
                                <?php echo !empty($vehiculo['valor_fidegnido']) ? formatearMonto($vehiculo['valor_fidegnido']) : 'Valor N/D'; ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p>No se encontraron vehículos registrados.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            Reporte generado el <?php echo date('d/m/Y'); ?> - Este documento es confidencial y para uso exclusivo de personal autorizado.
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>