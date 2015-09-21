<?php

//------------------- CONFIGURACION DE WEB SERVICE SOAP ----------------//
define("SOAP", "http://local.webservice.sipan/Produccion");
//define("SOAP", "http://services.moche.pe/Produccion");
//------------------- CONFIGURACION DE BASE DE DATOS ----------------//
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "sec_user");    // The database username. 
define("PASSWORD", "eKcGZr59zAa2BEWU");    // The database password. 
define("DATABASE", "secure_login");    // The database name.
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");


//------------------- CONFIGURACION DE CORREO ----------------//
define("SSL", "ssl");     
define("SMTP", "smtp.gmail.com");     
define("PORT", 465);     
define("USERNAME", "contacto@voy.pe");    
define("PASSWORDSMTP", "V0Y#Cont4cto.");
define("FROM", "contacto@voy.pe");
define("FROMNAME", "Voy");
define("WORDWRAP", 50);

//------------------- CUENTAS DE CORREO ----------------//

 	
define("FACTURACION", "josmelnyh89@gmail.com");
define("SOPORTE", "josmelnyh89@gmail.com");   
define("AddBCC", "jyupanqui@multibox.pe");
define("VENTAS", "noel_1705@hotmail.com");  
//------correo de Orden Nueva------//
define("SubjectOrdenNuevo", "Nueva Orden de Instalacion N° "); 
define("SubjectOrdenCurso", "Orden de Instalacion en Curso N° ");
//------correo de Orden Instalada------//
define("SubjectOrdenInstalado", "Orden Terminado de  Contrato N° "); 

define("SubjectContratoActivo", "Ficha de Alta - Contrato N° "); 

//------------------- ESTADOS ----------------//
////-----cliente----------//
define("ClienteActivo", 8);  
define("ContratarPorWeb", 15); 
//-----estados contrato----------//
define("ContratoPendiente", 6);     
define("ContratoPorInstalar", 9);  
define("ContratoActivo", 1);  
//-----estados orden----------//
define("OrdenePendiente", 7);  
define("OrdenNuevo", 6);
define("OrdenEnCurso", 11);
define("OrdenCerrado", 8);

//-----estados predio----------//
define("InstalacionPotencial", 6);
define("PredioFactible", 7);
define("PredioNoFactible", 8);
define("SubjectPredioFactible","Orden Terminado de  Contrato N° "); 
define("SubjectPredioNoFactible","Ficha de Alta - Contrato N° "); 

//------------------- ENTORNO ----------------//
define("AMBIENTE","dashboard");

 
define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!