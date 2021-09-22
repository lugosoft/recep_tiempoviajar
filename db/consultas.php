<?php 
$query = array();
/*---------------------------------------------------S E L E C T S---------------------------------------------*/
$query["queryOficina"] = "SELECT nomofi, prefijo FROM OFICINAS where codofi='#p1'";
$query["queryListaOficinas"] = "SELECT codofi,nomofi,prefijo FROM OFICINAS order by CASE WHEN CODOFI = 'PRI' THEN '0' ELSE nomofi END";

$query["queryRefCodes"] = "SELECT valor2 FROM REF_CODES where dominio='#p1' and valor='#p2'";
$query["queryRefCodesXDominio"] = "SELECT valor,valor2 FROM REF_CODES where dominio='#p1' order by valor";

$query["queryLogin"] = "SELECT '1' FROM USUARIOS WHERE codusr='#p1' and clave='#p2'";
$query["queryNameUser"] = "SELECT nombre, apellidos as telefono FROM USUARIOS where codusr='#p1'";

$query["queryNumResSiguiente"] = "SELECT top 1 num FROM CONSECUTIVOS WHERE tipo='RES' and estado='LIB' ORDER BY num";
$query["queryNumConsecMax"] = "SELECT ISNULL(MAX(NUM),0)+1 AS NUM FROM CONSECUTIVOS WHERE tipo='#p1'";
//$query["queryNumVouSiguiente"] = "SELECT top 1 num FROM CONSECUTIVOS WHERE tipo='VOU' and estado='LIB' ORDER BY num";
$query["queryNumVouSiguiente"] = "SELECT top 1 num FROM CONSECUTIVOS WHERE tipo='VOU #p1' and estado='LIB' ORDER BY num";

$query["queryNumTransSiguiente"] = "SELECT top 1 num FROM CONSECUTIVOS WHERE tipo='#p1' and estado='DIS' ORDER BY num";

$query["queryReserva"] = "SELECT 
                            TOP 20 resres, nompax, codnac, numpax, Convert(varchar, fllega, 102) AS fllega, 
                            Convert(varchar, fsale, 102) AS fsale, codhot, vuelle, vuesal, obs, codcli, codusr, 
                            Convert(varchar, fdigita, 102) AS fdigita, ISNULL(borrada,'NO') as borrada, voucher, telpax, documento,
                            horalle, horasal, codpaq, asesorage  
                          FROM RESERVAS 
                          WHERE numres = '#p1' 
                          AND CODOFI = '#p2'
                          order by resres";
                          
$query["queryReservaCli"] = "SELECT resres, nompax, codnac, numpax, Convert(varchar, fllega, 102) AS fllega, 
                             Convert(varchar, fsale, 102) AS fsale, codhot, vuelle, vuesal, obs, codcli, 
                             codusr, Convert(varchar, fdigita, 102) AS fdigita, ISNULL(borrada,'NO') as borrada, 
                             voucher, telpax, documento, horalle, horasal, codpaq 
                             FROM RESERVAS 
                             WHERE numres = '#p1' 
                             and codcli = '#p2' 
                             order by resres";

$query["queryReservaXResRes"] = "SELECT resres, nompax, codnac, numpax, Convert(varchar, fllega, 102) AS fllega, 
                                  Convert(varchar, fsale, 102) AS fsale, codhot, vuelle, vuesal, obs, codcli, codusr, 
                                  Convert(varchar, fdigita, 102) AS fdigita, ISNULL(borrada,'NO') as borrada, voucher, documento, 
                                  horalle, horasal, codpaq  
                                FROM RESERVAS 
                                WHERE numres = '#p1' 
                                and resres = '#p2'";

$query["queryReservaExiste"] = "select r.numres, r.resres, r.nompax, r.numpax, r.voucher, 
                                dbo.getFechaInterfaz(r.fllega), dbo.getFechaInterfaz(r.fsale), r.codcli   
                                from reservas r 
                                where 
                                (( 
                                (CONVERT(varchar, r.fllega+1, 112) >= #p1 AND CONVERT(varchar, r.fllega-1, 112) <= #p1) OR 
                                (CONVERT(varchar, r.fsale+1, 112) >= #p2 AND CONVERT(varchar, r.fsale-1, 112) <= #p2) 
                                ) OR (voucher = '#p5') ) 
                                AND r.nompax+' ' LIKE '#p3' 
                                AND r.nompax+' ' LIKE '#p4' 
                                AND r.borrada is null";

$query["queryReservaXNomPax"] = "SELECT 
                                    TOP 20 numres, resres, nompax, codnac, Convert(varchar, fllega, 102) AS fllega, 
                                    codcli, ISNULL(borrada,'NO') as borrada, documento, horalle, horasal, codpaq   
                                 FROM RESERVAS 
                                 where codofi = '#p2' 
                                 and (nompax like '%#p1%' or documento = '#p1')";
                                 
$query["queryReservaXNomPaxCli"] = "SELECT TOP 20 numres, resres, nompax, codnac, 
                                    Convert(varchar, fllega, 102) AS fllega, codcli, ISNULL(borrada,'NO') as borrada, 
                                    documento, horalle, horasal, codpaq 
                                    FROM RESERVAS where (nompax like '%#p1%'  or documento = '#p1') 
                                    and codcli = '#p2'";
                                    
//$query["queryServicioReserva"] = "SELECT resres, codser FROM RESERVAS_TOUR WHERE numres = '#p1' and resres = '#p2' order by resres";
$query["queryServicioReserva"] = "SELECT resres, codser 
									FROM RESERVAS_TOUR 
									WHERE numres = '#p1' 
									and resres = '#p2' 
									and CODSER in (SELECT RT.CODSER 
													FROM RESERVAS_TOUR RT
													WHERE RT.NUMRES = '#p1' 
													AND RT.RESRES = '#p2' 
													EXCEPT 
													SELECT CODSER 
													FROM SERVICIOS_PAQUETES 
													WHERE CODPAQ IN ( SELECT RT.CODSER 
																	  FROM RESERVAS_TOUR RT, SERVICIOS S 
																	  WHERE RT.CODSER = S.CODSER 
																	  AND S.TIPO = 'PAQ' 
																	  AND RT.NUMRES = '#p1' 
																	  AND RT.RESRES = '#p2'))
									order by resres";
$query["queryCliente"] = "SELECT codcli, nomcli, dircli, ciucli, te1cli, te2cli, celcli, concli, tipocli, nitcli FROM CLIENTES where codcli='#p1'";
$query["queryServicio"] = "SELECT codser, nomser, seldefecto, ordensale, lugar, precioadu, precioinf FROM SERVICIOS where codser='#p1'";
$query["queryIsPaquete"] = "SELECT 'SI' FROM SERVICIOS where codser='#p1' and tipo = 'PAQ'";
$query["queryUbicacion"] = "SELECT codubi, nomubi, dirubi, te1ubi, te2ubi, celubi, conubi, tipoubi, codofi FROM UBICACIONES where codubi='#p1'";
$query["queryListaClientes"] = "SELECT codcli, IFNULL(TEL2, nomcli) FROM CLIENTES order by IFNULL(TEL2, nomcli)";

$query["queryListaClientesShort"] = "SELECT 
                                      codcli, 
                                      CASE WHEN (ISNULL(TE2CLI, '') = '') THEN NOMCLI ELSE TE2CLI END AS NOMBRE 
                                      FROM CLIENTES 
                                     ORDER BY NOMBRE";

$query["queryListaRoles"] = "SELECT codrol,descrol FROM ROLES order by descrol";
$query["queryListaServicios"] = "SELECT codser,nomser,seldefecto FROM SERVICIOS order by ordensale,nomser,codser";
$query["queryListaServicios2"] = "SELECT codser,nomser,seldefecto FROM SERVICIOS WHERE TIPO IS NULL order by ordensale,nomser,codser";
$query["queryListaServiciosPq"] = "SELECT codser FROM SERVICIOS_PAQUETES WHERE codpaq = '#p1' order by codser";
$query["queryListaServiciosPq2"] = "SELECT SP.codser, S.nomser 
									FROM SERVICIOS_PAQUETES SP, SERVICIOS S 
									WHERE SP.CODSER = S.CODSER AND 
									SP.codpaq = '#p1' 
									order by S.seldefecto desc";

$query["queryListaProveedores"] = "SELECT codpro,nompro FROM PROVEEDORES order by nompro,codpro";
$query["queryListaProveedoresXServ"] = "SELECT SP.codpro, (select nompro from PROVEEDORES P where P.codpro = SP.codpro) as nompro FROM SERVICIOSXPROVEEDOR SP WHERE SP.codser = '#p1' order by nompro";
$query["queryListaHoteles"] = "SELECT codubi,nomubi FROM UBICACIONES where tipoubi='HOT' and codofi = '#p1' order by nomubi";
$query["queryListaHotelesAll"] = "SELECT codubi,nomubi FROM UBICACIONES where tipoubi='HOT' order by nomubi";

$query["queryListaPaquetes"] = "SELECT CODPAQ,NOMPAQ,DESCPAQ FROM PAQUETES WHERE CODOFI = '#p1' order by NOMPAQ";
$query["queryListaPaquetesAll"] = "SELECT CODPAQ,NOMPAQ,DESCPAQ FROM PAQUETES order by NOMPAQ";
$query["queryListaOtrUbi"] = "SELECT codubi,nomubi FROM UBICACIONES where tipoubi='OTR' order by nomubi";
$query["queryListaArpUbi"] = "SELECT codubi,nomubi FROM UBICACIONES where tipoubi='ARP' order by nomubi";
$query["queryListaMueUbi"] = "SELECT codubi,nomubi FROM UBICACIONES where tipoubi='MUE' order by nomubi";
$query["queryListaUsuarios"] = "SELECT codusr,nombre,apellidos FROM USUARIOS order by codusr";
$query["queryListaOperacionesLog"] = "SELECT valor,valor2 FROM REF_CODES where dominio='TIPOLOG' order by valor";
$query["queryListaTablasLog"] = "SELECT valor,valor2 FROM REF_CODES where dominio='TABLALOG' order by valor";
$query["queryListaNacionalidades"] = "SELECT codnac,nacional FROM NACIONALIDADES order by nacional";
$query["queryListaTours"] = "SELECT CODTOUR, 
                                dbo.getFechaInterfaz(ftour)+' '+SUBSTRING(Convert(varchar, ftour, 108),1,5) AS fhtour, 
                                ftour 
                              FROM TOURS 
                              WHERE CODSER = '#p1' 
                                AND CONVERT(varchar, ftour, 112) >= #p2 
                                AND borrado is null 
                                AND CODOFI = '#p3' 
                              ORDER BY ftour";

$query["queryListaToursResXPax"] = "SELECT RT.CODSER, 
									(SELECT S.NOMSER FROM SERVICIOS S WHERE S.CODSER = RT.CODSER) AS NOMSER 
									FROM RESERVAS_TOUR RT, RESERVAS R 
									WHERE RT.NUMRES = R.NUMRES AND 
									RT.RESRES = R.RESRES AND 
									RT.NUMRES = '#p1' AND 
									RT.RESRES = '#p2' AND 
									(SELECT ISNULL(SUM(numpax),0) 
									FROM SERVICIOS_PARTICULAR SP, TOURS T 
									WHERE SP.CODTOUR = T.CODTOUR AND 
									SP.DOCUMENTO = '#p1-#p2' 
									AND T.CODSER = RT.CODSER 
									AND SP.BORRADO IS NULL) < R.numpax
									ORDER BY NOMSER";

$query["queryNumPaxFaltaTour"] = "SELECT (R.numpax - (SELECT ISNULL(SUM(numpax),0) 
                                            FROM SERVICIOS_PARTICULAR SP, TOURS T 
                                            WHERE SP.CODTOUR = T.CODTOUR AND 
                                            SP.DOCUMENTO = '#p1-#p2' 
                                            AND T.CODSER = '#p3' 
                                            AND SP.BORRADO IS NULL)) as num 
                                  FROM RESERVAS R 
                                  WHERE R.NUMRES = '#p1' AND 
                                  R.RESRES = '#p2'";
									
$query["queryListaPaxServXRes"] = "SELECT R.NUMRES, R.RESRES, R.NOMPAX 
                                  FROM RESERVAS R 
                                  WHERE R.NUMRES = '#p1' 
                                  AND R.CODOFI = '#p2' 
                                  AND R.BORRADA IS NULL 
                                  AND EXISTS(SELECT 1 FROM RESERVAS_TOUR SP 
                                        WHERE SP.NUMRES = R.NUMRES) 
                                  ORDER BY NOMPAX";							

$query["queryListaPaxServXDoc"] = "SELECT R.NUMRES, R.RESRES, R.NOMPAX 
                                    FROM RESERVAS R 
                                    WHERE R.DOCUMENTO = '#p1' 
                                    AND R.CODOFI = '#p2' 
                                    AND R.BORRADA IS NULL 
                                    AND EXISTS(SELECT 1 FROM RESERVAS_TOUR SP 
                                              WHERE SP.NUMRES = R.NUMRES
                                              AND CONFIRMADA IS NULL) 
                                    ORDER BY NOMPAX";		
                
$query["queryConteoServicios"] = "SELECT count(*) FROM SERVICIOS";
$query["queryConteoProveedores"] = "SELECT count(*) FROM PROVEEDORES";
$query["queryUsuario"] = "SELECT codusr, clave, codrol, nombre, apellidos, Convert(varchar, fdigita, 102) AS fdigita, codusrdig, codcli FROM USUARIOS where codusr='#p1'";
$query["queryNacionalidad"] = "SELECT codnac,nacional FROM NACIONALIDADES where codnac='#p1' order by nacional";
$query["queryProveedor"] = "SELECT codpro, nompro, dirpro, te1pro, te2pro, celpro, conpro, cupos FROM PROVEEDORES where codpro='#p1'";

$query["queryPaquete"] = "SELECT codpaq, nompaq, descpaq, codofi FROM PAQUETES where codpaq='#p1'";

$query["queryProveedoresServicio"] = "SELECT codpro,cosser FROM SERVICIOSXPROVEEDOR WHERE codser = '#p1'";
$query["queryPermisoUsuario"] = "SELECT 'SI' as res FROM PERMISOSXROL WHERE codrol = (SELECT codrol FROM USUARIOS WHERE CODUSR = '#p1') and codper = '#p2'";

$query["queryVuelo"] = "SELECT  tipovlo, 
								nrovlo, 
								horavlo 
						   FROM VUELOS 
						   WHERE tipovlo = '#p1' and 
						   nrovlo = '#p2'";

$query["queryVuelosXTipo"] = "SELECT  tipovlo, 
								nrovlo 
						   FROM VUELOS 
						   WHERE tipovlo = '#p1' 
						   order by nrovlo";
						   
$query["queryVuelosSearch1"] = "SELECT  tipovlo, 
									nrovlo, 
									horavlo  
							   FROM VUELOS 
							   WHERE tipovlo = '#p1' and 
							   nrovlo like '%#p2%' 
							   ORDER BY tipovlo, nrovlo";

$query["queryVuelosSearch2"] = "SELECT  tipovlo, 
									nrovlo, 
									horavlo  
							   FROM VUELOS 
							   WHERE tipovlo = '#p1' 
							   ORDER BY tipovlo, nrovlo";					   

$query["queryConsecutivo"] = "SELECT tipo, num, estado 
									FROM CONSECUTIVOS 
									WHERE tipo like '#p1%' and num = '#p2'";

$query["queryRangoConsecutivo"] = "SELECT top 1 num 
									FROM CONSECUTIVOS 
									WHERE tipo like '#p1%' and num >= '#p2' and num <= '#p3' ORDER BY num";									
									
$query["queryConsecutivosSearch1"] = "SELECT tipo, num, estado 
									FROM CONSECUTIVOS 
									WHERE tipo like '#p1%' and num >= '#p2' and num <= '#p3' 
									ORDER BY num";
							   
$query["queryConsecutivosSearch2"] = "SELECT tipo, num, estado 
									FROM CONSECUTIVOS 
									WHERE tipo like '#p1%' and num >= '#p2' and num <= '#p3' and estado = '#p4' 
									ORDER BY num";							   

$query["queryRegistroLog"] = "SELECT '1' FROM REF_CODES WHERE dominio='REGISTROLOG' and valor='#p1' and valor2='SI'";

$query["queryReporteAgencias"] = "SELECT 
                                    codcli, 
                                    nitcli, 
                                    nomcli, 
                                    te2cli as nombre_corto, 
                                    dircli, 
                                    ciucli, 
                                    te1cli, 
                                    celcli, 
                                    concli AS email 
                                  FROM clientes
                                  WHERE nitcli LIKE '#p1'
                                  AND nomcli LIKE '#p2'
                                  order by nomcli";
                                  
$query["queryReporteHoteles"] = "SELECT 
                                    codubi,  
                                    nomubi, 
                                    codofi 
                                  FROM ubicaciones
                                  WHERE nomubi LIKE '#p1'
                                  AND codofi LIKE '#p2'
                                  order by codofi, nomubi";
							
$query["queryReporteConsecReserva"] = "SELECT 
                                        res.CODOFI,
                                        numres,
                                        resres,
                                        borrada,
                                        dbo.getFechaInterfaz(fdigita) AS fdigita, 
                                        c.nomcli, 
                                        nompax,
                                        numpax, 
                                        telpax,
                                        paq.nompaq,
                                        res.asesorage,
                                        res.voucher,
                                        dbo.getFechaInterfaz(fllega) AS fllega, 
                                        dbo.getFechaInterfaz(fsale) AS fsale, 
                                        u.nomubi, 
                                        ISNULL((SELECT TOP 1 'X' FROM RESERVAS_TOUR T, SERVICIOS S 
                                        WHERE T.codser = S.codser AND T.numres = res.numres AND T.resres = res.resres 
                                        AND S.NOMSER LIKE 'TRANSFER IN%'),'') AS trfin,
                                        ISNULL((SELECT TOP 1 'X' FROM RESERVAS_TOUR T, SERVICIOS S 
                                        WHERE T.codser = S.codser AND T.numres = res.numres AND T.resres = res.resres 
                                        AND S.NOMSER LIKE 'TRANSFER OUT%'),'') AS trfout, 
                                        ISNULL((SELECT TOP 1 'X' FROM RESERVAS_TOUR T, SERVICIOS S 
                                        WHERE T.codser = S.codser AND T.numres = res.numres AND T.resres = res.resres  
                                        AND S.NOMSER NOT LIKE 'TRANSFER IN%' AND S.NOMSER NOT LIKE 'TRANSFER OUT%'),'') AS otrservs                       
                                      FROM RESERVAS res, paquetes paq, clientes c, ubicaciones u 
                                      WHERE 
                                        res.codpaq = paq.codpaq AND 
                                        res.codcli = c.codcli AND
                                        res.codhot = u.codubi AND
                                        CONVERT(varchar, fdigita, 112) >= '#p1' AND 
                                        CONVERT(varchar, fdigita, 112) <= '#p2' AND  
                                        res.CODOFI LIKE '#p4' AND 
                                        res.CODCLI LIKE '#p5' 
                                      ORDER BY numres, resres";

$query["queryReporteConsecReserva2"] = "SELECT 
                                          res.CODOFI,
                                          numres,
                                          resres,
                                          borrada,
                                          dbo.getFechaInterfaz(fdigita) AS fdigita, 
                                          c.nomcli, 
                                          nompax,
                                          numpax, 
                                          telpax,
                                          paq.nompaq,
                                          res.asesorage,
                                          res.voucher,
                                          dbo.getFechaInterfaz(fllega) AS fllega, 
                                          dbo.getFechaInterfaz(fsale) AS fsale, 
                                          u.nomubi, 
                                          ISNULL((SELECT TOP 1 'X' FROM RESERVAS_TOUR T, SERVICIOS S 
                                          WHERE T.codser = S.codser AND T.numres = res.numres AND T.resres = res.resres 
                                          AND S.NOMSER LIKE 'TRANSFER IN%'),'') AS trfin,
                                          ISNULL((SELECT TOP 1 'X' FROM RESERVAS_TOUR T, SERVICIOS S 
                                          WHERE T.codser = S.codser AND T.numres = res.numres AND T.resres = res.resres 
                                          AND S.NOMSER LIKE 'TRANSFER OUT%'),'') AS trfout, 
                                          ISNULL((SELECT TOP 1 'X' FROM RESERVAS_TOUR T, SERVICIOS S 
                                          WHERE T.codser = S.codser AND T.numres = res.numres AND T.resres = res.resres  
                                          AND S.NOMSER NOT LIKE 'TRANSFER IN%' AND S.NOMSER NOT LIKE 'TRANSFER OUT%'),'') AS otrservs                       
                                        FROM RESERVAS res, paquetes paq, clientes c, ubicaciones u 
                                        WHERE 
                                          res.codpaq = paq.codpaq AND 
                                          res.codcli = c.codcli AND
                                          res.codhot = u.codubi AND
                                          CONVERT(varchar, fllega, 112) >= '#p1' AND 
                                          CONVERT(varchar, fllega, 112) <= '#p2' AND  
                                          res.CODOFI LIKE '#p4' AND 
                                          res.CODCLI LIKE '#p5' 
                                        ORDER BY numres, resres";

$query["queryReporteReserNoConfir"] = "SELECT 
                                         RR.CODOFI,
                                         RR.NUMRES, 
                                         RR.RESRES, 
                                         RR.CODUSR,
                                         RR.NOMPAX, 
                                         RR.NUMPAX,
                                         ISNULL(SS.NOMSER, 'RESERVA SIN TOURS') AS NOMSER,
                                         dbo.getFechaInterfaz(RR.fllega) AS fllega, 
                                         dbo.getFechaInterfaz(RR.fsale) AS fsale,
                                         PP.NOMPAQ,
                                         CC.NOMCLI,
                                         RR.VOUCHER, 
                                         dbo.getFechaInterfaz(RR.fdigita) AS fdigita
                                      FROM 
                                      (
                                        (
                                        SELECT 
                                           RT.NUMRES, 
                                           RT.RESRES, 
                                           RT.CODSER
                                         FROM RESERVAS R
                                         INNER JOIN RESERVAS_TOUR RT ON (R.NUMRES = RT.NUMRES AND R.RESRES = RT.RESRES)
                                         WHERE R.BORRADA IS NULL AND 
                                          (CONVERT(varchar, R.fdigita, 112) >= '#p1' AND 
                                           CONVERT(varchar, R.fdigita, 112) <= '#p2') 
                                        EXCEPT
                                        SELECT 
                                           R.NUMRES, 
                                           R.RESRES,
                                           U.CODSER
                                         FROM RESERVAS R
                                         INNER JOIN SERVICIOS_PARTICULAR SP ON (CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento AND SP.borrado is NULL)
                                         INNER JOIN TOURS U ON (U.CODTOUR = SP.CODTOUR)
                                         WHERE R.BORRADA IS NULL AND 
                                          (CONVERT(varchar, R.fdigita, 112) >= '#p1' AND 
                                           CONVERT(varchar, R.fdigita, 112) <= '#p2')
                                        )
                                        UNION ALL
                                        SELECT 
                                           R.NUMRES, 
                                           R.RESRES, 
                                           RT.CODSER
                                         FROM RESERVAS R
                                         LEFT OUTER JOIN RESERVAS_TOUR RT ON (R.NUMRES = RT.NUMRES AND R.RESRES = RT.RESRES)
                                         WHERE R.BORRADA IS NULL AND 
                                          (CONVERT(varchar, R.fdigita, 112) >= '#p1' AND 
                                           CONVERT(varchar, R.fdigita, 112) <= '#p2') 
                                        AND RT.CODSER IS NULL
                                      ) X
                                      INNER JOIN RESERVAS RR ON (RR.NUMRES = X.NUMRES AND RR.RESRES = X.RESRES)
                                      INNER JOIN PAQUETES PP ON (PP.CODPAQ = RR.CODPAQ)
                                      INNER JOIN CLIENTES CC ON (CC.CODCLI = RR.CODCLI)
                                      LEFT OUTER JOIN SERVICIOS SS ON (SS.CODSER = X.CODSER)
                                      WHERE RR.CODOFI LIKE '#p3' AND 
                                      RR.CODCLI LIKE '#p4' AND 
                                      RR.CODPAQ LIKE '#p5' 
                                      ORDER BY RR.NUMRES, RR.RESRES";

$query["queryReporteNoConfirByReserva"] = "SELECT 
                                             RR.CODOFI,
                                             RR.NUMRES, 
                                             RR.RESRES, 
                                             RR.CODUSR,
                                             RR.NOMPAX, 
                                             RR.NUMPAX,
                                             ISNULL(SS.NOMSER, 'RESERVA SIN TOURS') AS NOMSER,
                                             dbo.getFechaInterfaz(RR.fllega) AS fllega, 
                                             dbo.getFechaInterfaz(RR.fsale) AS fsale,
                                             PP.NOMPAQ,
                                             CC.NOMCLI,
                                             RR.VOUCHER,
                                             dbo.getFechaInterfaz(RR.fdigita) AS fdigita
                                          FROM 
                                          (
                                            (
                                            SELECT 
                                               RT.NUMRES, 
                                               RT.RESRES, 
                                               RT.CODSER
                                             FROM RESERVAS R
                                             INNER JOIN RESERVAS_TOUR RT ON (R.NUMRES = RT.NUMRES AND R.RESRES = RT.RESRES)
                                             WHERE R.BORRADA IS NULL AND 
                                              (R.NUMRES = '#p1') 
                                            EXCEPT
                                            SELECT 
                                               R.NUMRES, 
                                               R.RESRES,
                                               U.CODSER
                                             FROM RESERVAS R
                                             INNER JOIN SERVICIOS_PARTICULAR SP ON (CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento AND SP.borrado is NULL)
                                             INNER JOIN TOURS U ON (U.CODTOUR = SP.CODTOUR)
                                             WHERE R.BORRADA IS NULL AND 
                                              (R.NUMRES = '#p1')
                                            )
                                            UNION ALL
                                            SELECT 
                                               R.NUMRES, 
                                               R.RESRES, 
                                               RT.CODSER
                                             FROM RESERVAS R
                                             LEFT OUTER JOIN RESERVAS_TOUR RT ON (R.NUMRES = RT.NUMRES AND R.RESRES = RT.RESRES)
                                             WHERE R.BORRADA IS NULL AND 
                                              (R.NUMRES = '#p1') 
                                            AND RT.CODSER IS NULL
                                          ) X
                                          INNER JOIN RESERVAS RR ON (RR.NUMRES = X.NUMRES AND RR.RESRES = X.RESRES)
                                          INNER JOIN PAQUETES PP ON (PP.CODPAQ = RR.CODPAQ)
                                          INNER JOIN CLIENTES CC ON (CC.CODCLI = RR.CODCLI)
                                          LEFT OUTER JOIN SERVICIOS SS ON (SS.CODSER = X.CODSER)
                                          ORDER BY RR.NUMRES, RR.RESRES";
										
$query["queryReporteConsecReservaCli"] = "	SELECT 
											numres,
											resres,
											dbo.getFechaInterfaz(fdigita) AS fdigita, 
											(SELECT nomcli 
											FROM CLIENTES 
											where codcli = res.codcli) AS codcli, 
											nompax,
											numpax,
											voucher,
											dbo.getFechaInterfaz(fllega) AS fllega, 
											dbo.getFechaInterfaz(fsale) AS fsale, 
											codhot, 
											ISNULL((SELECT 'X' FROM RESERVAS_TOUR 
											WHERE numres = res.numres AND resres = res.resres 
											AND codser = 'IN'),'') AS trfin,
											ISNULL((SELECT 'X' FROM RESERVAS_TOUR 
											WHERE numres = res.numres AND resres = res.resres 
											AND codser = 'OUT'),'') AS trfout,
											ISNULL((SELECT TOP 1 'X' FROM RESERVAS_TOUR 
											WHERE numres = res.numres AND resres = res.resres  
											AND codser <> 'IN' AND codser <> 'OUT'),'') AS otrservs 
										FROM RESERVAS res WHERE 
											CONVERT(varchar, fdigita, 112) >= '#p1' AND 
											CONVERT(varchar, fdigita, 112) <= '#p2' AND  
											codcli = '#p3' AND 
											borrada is null AND 
                      CODOFI LIKE '#p4'  
										ORDER BY numres, resres";
/*										
$query["queryReporteLlegadas"] = "SELECT 
                                    r.numres, 
                                    r.resres, 
                                    r.vuelle, 
                                    r.horalle,
                                    r.codcli, 
                                    SUBSTRING(Convert(varchar, u.FTOUR, 108),1,5) AS htour,
                                    r.nompax, 
                                    r.numpax, 
                                    r.telpax, 
                                    (SELECT p.nompaq FROM PAQUETES p WHERE p.codpaq = r.codpaq) as paquete, 
                                    (SELECT nomubi FROM UBICACIONES u WHERE u.codubi = r.codhot) as hotel, 
                                    '' as firma
                                  FROM RESERVAS r, RESERVAS_TOUR t, SERVICIOS S, 
                                  SERVICIOS_PARTICULAR SP, TOURS U 
                                  WHERE T.codser = S.codser AND
                                  r.numres = t.numres AND
                                  r.resres = t.resres AND
                                  U.CODTOUR = SP.CODTOUR AND 
                                  SP.borrado is null AND
                                  CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento AND 
                                  U.codser = S.codser AND
                                  s.nomser like 'TRANSFER IN%' AND
                                  ISNULL(t.confirmada, 'NO') = 'SI' AND
                                  R.fllega = '#p1 00:00' AND
                                  R.vuelle like '#p2' AND 
                                  R.codhot like '#p3' AND 
                                  R.codcli like '#p4' AND 
                                  R.codnac like '#p5' AND 
                                  R.codofi like '#p6' AND 
                                  SUBSTRING(CONVERT(varchar, U.FTOUR, 108),1,5) LIKE '#p7' AND 
                                  R.borrada is null 
                                  ORDER BY vuelle, codcli, nompax";*/

$query["queryReporteLlegadas"] = "SELECT 
                                    r.numres, 
                                    r.resres, 
                                    dbo.getFechaInterfaz(r.fllega) AS fllega,
                                    r.vuelle, 
                                    r.horalle,
                                    c.nomcli, 
                                    r.horalle,
                                    r.nompax, 
                                    r.numpax, 
                                    r.telpax, 
                                    p.nompaq, 
                                    u.nomubi, 
                                    '' as firma
                                  FROM RESERVAS r, RESERVAS_TOUR t, SERVICIOS S, CLIENTES C, PAQUETES p, UBICACIONES u
                                  WHERE T.codser = S.codser AND
                                    r.numres = t.numres AND
                                    r.resres = t.resres AND
                                    r.codcli = c.codcli AND 
                                    p.codpaq = r.codpaq AND 
                                    u.codubi = r.codhot AND 
                                    s.nomser like 'TRANSFER IN%' AND
                                    R.fllega >= '#p1 00:00' AND 
                                    R.fllega <= '#p2 23:59' AND 
                                    R.vuelle like '#p3' AND 
                                    R.codhot like '#p4' AND 
                                    R.codcli like '#p5' AND 
                                    R.codnac like '#p6' AND 
                                    R.codofi like '#p7' AND 
                                    r.horalle LIKE '#p8' AND 
                                    R.CODPAQ LIKE '#p9' AND 
                                    R.borrada is null 
                                  ORDER BY R.fllega, vuelle, r.codcli, nompax";
                                  
$query["queryReporteSalidas"] = "SELECT 
                                    R.vuesal, 
                                    R.horasal, 
                                    (SELECT nomubi FROM UBICACIONES u WHERE u.codubi = r.codhot) as hotel, 
                                    r.numres, 
                                    r.resres, 
                                    SUBSTRING(Convert(varchar, u.FTOUR, 108),1,5) AS htour,
                                    R.nompax, 
                                    R.numpax, 
                                    R.telpax,
                                    C.NOMCLI, 
                                    '' as firma 
                                  FROM RESERVAS r, RESERVAS_TOUR t, SERVICIOS S, 
                                  SERVICIOS_PARTICULAR SP, TOURS U, clientes C 
                                  WHERE T.codser = S.codser AND
                                    r.numres = t.numres AND
                                    r.resres = t.resres AND
                                    U.CODTOUR = SP.CODTOUR AND 
                                    SP.borrado is null AND
                                    CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento AND 
                                    U.codser = S.codser AND 
                                    R.CODCLI = C.CODCLI AND 
                                    s.nomser like 'TRANSFER OUT%' AND
                                    R.fsale = '#p1 00:00' AND
                                    R.vuesal like '#p2' AND 
                                    R.codhot like '#p3' AND 
                                    R.codcli like '#p4' AND 
                                    R.codnac like '#p5' AND 
                                    R.codofi like '#p6' AND 
                                    SUBSTRING(CONVERT(varchar, U.FTOUR, 108),1,5) LIKE '#p7' AND 
                                    R.borrada is null 
                                  ORDER BY horasal, hotel, vuesal, nompax";
								
$query["queryReporteSalidasXRes"] = "SELECT 
                                        dbo.getFechaInterfaz(R.FSALE) AS FSALE, 
                                        vuesal, 
                                        horasal, 
                                        (SELECT nomubi FROM UBICACIONES u WHERE u.codubi = r.codhot) as hotel, 
                                        r.numres, 
                                        r.resres, 
                                        documento,
                                        nompax, 
                                        numpax, 
                                        codcli, 
                                        '' as firma, 
                                        codofi 
                                      FROM RESERVAS r, RESERVAS_TOUR t 
                                      WHERE r.numres = t.numres AND
                                      r.resres = t.resres AND
                                      t.codser = 'OUT' AND
                                      r.numres = '#p1' AND 
                                      resres like '#p2' AND 
                                      borrada is null 
                                      ORDER BY horasal, hotel, vuesal, nompax";

$query["queryReportePasXRes"] = "SELECT 
                                  codofi,
                                  resres, 
                                  documento,
                                  nompax, 
                                  numpax, 
                                  codnac, 
                                  dbo.getFechaInterfaz(fllega) AS fllega, 
                                  dbo.getFechaInterfaz(fsale) AS fsale, 
                                  codhot, 
                                  vuelle,
                                  vuesal, 
                                  ISNULL((SELECT TOP 1 'X' FROM RESERVAS_TOUR T, SERVICIOS S 
                                  WHERE T.codser = S.codser AND T.numres = res.numres AND T.resres = res.resres 
                                  AND S.NOMSER LIKE 'TRANSFER IN%'),'') AS trfin,
                                  ISNULL((SELECT TOP 1 'X' FROM RESERVAS_TOUR T, SERVICIOS S 
                                  WHERE T.codser = S.codser AND T.numres = res.numres AND T.resres = res.resres 
                                  AND S.NOMSER LIKE 'TRANSFER OUT%'),'') AS trfout, 
                                  ISNULL((SELECT TOP 1 'X' FROM RESERVAS_TOUR T, SERVICIOS S 
                                  WHERE T.codser = S.codser AND T.numres = res.numres AND T.resres = res.resres  
                                  AND S.NOMSER NOT LIKE 'TRANSFER IN%' AND S.NOMSER NOT LIKE 'TRANSFER OUT%'),'') AS otrservs, 
                                  obs,
                                  (SELECT nomcli 
                                  FROM CLIENTES 
                                  where codcli = res.codcli) AS codcli,
                                  res.asesorage, 
                                  res.voucher 
                                FROM RESERVAS res WHERE 
                                numres = '#p1' AND 
                                borrada is null 
                                ORDER BY numres, resres";
								
$query["queryReportePasXVou"] = "SELECT 
									voucher, 
									numres, 
									resres, 
									documento,
									nompax, 
									numpax, 
									codnac, 
									dbo.getFechaInterfaz(fllega) AS fllega, 
									dbo.getFechaInterfaz(fsale) AS fsale, 
									codhot, 
									vuelle,
									vuesal, 
									ISNULL((SELECT 'X' FROM RESERVAS_TOUR 
									WHERE numres = res.numres AND resres = res.resres 
									AND codser = 'IN'),'') AS trfin,
									ISNULL((SELECT 'X' FROM RESERVAS_TOUR 
									WHERE numres = res.numres AND resres = res.resres 
									AND codser = 'OUT'),'') AS trfout, 
									ISNULL((SELECT TOP 1 'X' FROM RESERVAS_TOUR 
									WHERE numres = res.numres AND resres = res.resres  
									AND codser <> 'IN' AND codser <> 'OUT'),'') AS otrservs, 
									obs,
									(SELECT nomcli 
									FROM CLIENTES 
									where codcli = res.codcli) AS codcli 
								FROM RESERVAS res WHERE 
								voucher = '#p1' AND 
								borrada is null 
								ORDER BY numres, resres";
								
$query["queryReporteLog1"] = "SELECT 
                              dbo.getFechaInterfaz(fecha) AS fecha, 
                              SUBSTRING(CONVERT(varchar, fecha, 108),1,5) AS hora, 
                              CODUSR,
                              (SELECT VALOR2 
                              FROM REF_CODES 
                              WHERE DOMINIO = 'TIPOLOG'
                              AND VALOR = l.tipo) as tipo,
                              (SELECT VALOR2 
                              FROM REF_CODES 
                              WHERE DOMINIO = 'TABLALOG'
                              AND VALOR = l.tabla) as tabla,
                              NUM,
                              DESCRIPCION, 
                              codofi  
                              FROM LOGS l WITH (INDEX(idx_tabla_num_logs)) 
                              WHERE tabla = '#p3' AND 
                                  num = '#p4' AND 
                                  codusr like '#p1' AND 
                                  tipo like '#p2' AND 
                                  codofi like '#p5'
                              ORDER BY fecha, hora, codusr"; /* Ojo - Si se cambia el where, cambiar tmb deleteReporteLog1 */
							
$query["queryReporteLog2"] = "SELECT 
                              dbo.getFechaInterfaz(fecha) AS fecha, 
                              SUBSTRING(CONVERT(varchar, fecha, 108),1,5) AS hora, 
                              CODUSR,
                              (SELECT VALOR2 
                              FROM REF_CODES 
                              WHERE DOMINIO = 'TIPOLOG'
                              AND VALOR = l.tipo) as tipo,
                              (SELECT VALOR2 
                              FROM REF_CODES 
                              WHERE DOMINIO = 'TABLALOG'
                              AND VALOR = l.tabla) as tabla,
                              NUM,
                              DESCRIPCION, 
                              codofi 
                              FROM LOGS l WITH (INDEX(idx_tabla_fecha_logs)) 
                              WHERE tabla = '#p5' AND 
                                  fecha >= '#p1 00:00' AND 
                                  fecha <= '#p2 23:59' AND 
                                  codusr like '#p3' AND 
                                  tipo like '#p4' AND 								  
                                  num like '#p6' AND 
                                  codofi like '#p7' 
                              ORDER BY fecha, hora, codusr"; /* Ojo - Si se cambia el where, cambiar tmb deleteReporteLog2 */
							
$query["queryReporteVentaTour"] = "SELECT 
                                      CONCAT(SP.CODOFI, '-', SP.numvou) as numvou, 
                                      SP.documento, 
                                      SP.tipo, 
                                      SP.nompax, 
                                      R.telpax,
                                      S.NOMSER, 
                                      dbo.getFechaInterfaz(T.FTOUR) AS ftour, 
                                      SUBSTRING(Convert(varchar, T.FTOUR, 108),1,5) AS htour, 
                                      UB.NOMUBI, 
                                      SP.codnac, 
                                      SP.numpax,  
                                      SP.NUMPAX1 AS ADULTOS,
                                      SP.NUMPAX2 AS INFANTES,
                                      T.LUGAR, 
                                      P.NOMPRO, 
                                      C.NOMCLI, 
                                      R.ASESORAGE, 
                                      SP.codusr, 
                                      U.APELLIDOS AS TELEFONO, 
                                      dbo.getFechaInterfaz(SP.fdigita) AS fdigita,
                                      SP.obs 
                                    FROM SERVICIOS_PARTICULAR SP, TOURS T, USUARIOS U, reservas R, CLIENTES C, PROVEEDORES P, ubicaciones UB, SERVICIOS S 
                                    WHERE  SP.codtour = T.codtour AND 
                                      SP.codusr = U.CODUSR AND 
                                      T.codser like '#p3' AND 
                                      T.codpro like '#p4' AND 
                                      SP.borrado IS NULL AND 
                                      CONVERT(varchar, T.FTOUR, 112) >= '#p1' AND 
                                      CONVERT(varchar, T.FTOUR, 112) <= '#p2' AND 
                                      SUBSTRING(CONVERT(varchar, T.FTOUR, 108),1,5) LIKE '#p5' AND 
                                      SP.tipo = 'Plan' AND 
                                      CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento AND 
                                      R.CODCLI = C.CODCLI AND 
                                      UB.CODUBI = R.CODHOT AND 
                                      P.CODPRO = T.CODPRO AND 
                                      S.CODSER = T.CODSER AND 
                                      R.CODCLI LIKE '#p6' AND 
                                      SP.CODOFI = '#p7'
                                    ORDER BY numvou";		

$query["queryReporteVentaTourXRes"] = "SELECT 
                                          CONCAT(SP.CODOFI, '-', SP.numvou) as numvou, 
                                          SP.documento, 
                                          (select documento from reservas where numres = 4 and resres = SUBSTRING(SP.documento, (CHARINDEX('-', SP.documento)+1), 10)) as documento,
                                          SP.nompax, 
                                          R.telpax,
                                          (SELECT S.nomser FROM SERVICIOS S where S.codser = T.codser) AS nomser, 
                                          dbo.getFechaInterfaz(T.FTOUR) AS ftour, 
                                          SUBSTRING(Convert(varchar, T.FTOUR, 108),1,5) AS htour, 
                                          UB.NOMUBI, 
                                          SP.codnac, 
                                          SP.numpax, 
                                          SP.NUMPAX1 AS ADULTOS,
                                          SP.NUMPAX2 AS INFANTES,
                                          T.LUGAR, 
                                          CONCAT(P.NOMPRO, '    Tel: ', P.TE1PRO) as nompro, 
                                          C.NOMCLI, 
                                          R.ASESORAGE, 
                                          R.VOUCHER, 
                                          U.nombre, 
                                          U.APELLIDOS AS TELEFONO, 
                                          dbo.getFechaInterfaz(SP.fdigita) AS fdigita, 
                                          SP.obs 
                                        FROM SERVICIOS_PARTICULAR SP, TOURS T, USUARIOS U, reservas R, clientes C, PROVEEDORES P, ubicaciones UB   
                                        WHERE  SP.codtour = T.codtour AND 
                                          SP.codusr = U.CODUSR AND    
                                          SP.documento like '#p1-#p2' AND 
                                          T.codser like '#p3' AND 
                                          CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento AND 
                                          R.CODCLI = C.CODCLI AND 
                                          UB.CODUBI = R.CODHOT AND 
                                          P.CODPRO = T.CODPRO AND 
                                          SP.borrado IS NULL 
                                        ORDER BY numvou";		
                                        

$query["queryReporteVentaDirectaTour"] = "SELECT 
                                          CONCAT(SP.CODOFI, '-', SP.numvou) as numvou,  
                                          SP.documento, 
                                          SP.tipo, 
                                          SP.nompax, 
                                          (SELECT S.nomser FROM SERVICIOS S where S.codser = T.codser) AS nomser, 
                                          dbo.getFechaInterfaz(T.FTOUR) AS ftour, 
                                          SUBSTRING(Convert(varchar, T.FTOUR, 108),1,5) AS htour, 
                                          (select u.NOMUBI from ubicaciones u where u.CODUBI = SP.codhot) as hot, 
                                          SP.codnac, 
                                          SP.numpax,  
                                          dbo.getValorConPuntos(SP.total) AS total, 
                                          SP.NUMPAX1 AS ADULTOS,
                                          dbo.getValorConPuntos(SP.precioxper) AS precioxadu, 
                                          SP.NUMPAX2 AS INFANTES,
                                          dbo.getValorConPuntos(SP.precioxper2) AS precioxinf, 
                                          T.LUGAR, 
                                          (select P.NOMPRO from PROVEEDORES P where P.CODPRO = T.CODPRO) as nompro, 
                                          SP.codusr, 
                                          U.APELLIDOS AS TELEFONO, 
                                          dbo.getFechaInterfaz(SP.fdigita) AS fdigita,
                                          SP.obs 
                                          FROM SERVICIOS_PARTICULAR SP, TOURS T, USUARIOS U  
                                          WHERE  SP.codtour = T.codtour AND 
                                          SP.codusr = U.CODUSR AND 
                                          T.codser like '#p3' AND 
                                          T.codpro like '#p4' AND 
                                          SP.borrado IS NULL AND 
                                          CONVERT(varchar, T.FTOUR, 112) >= '#p1' AND 
                                          CONVERT(varchar, T.FTOUR, 112) <= '#p2' AND 
                                          SUBSTRING(CONVERT(varchar, T.FTOUR, 108),1,5) LIKE '#p5' AND 
                                          SP.tipo = 'Particular' AND 
                                          SP.CODOFI LIKE '#p6' 
                                          ORDER BY numvou";		

$query["queryConsecutivoVentaTour"] =  "SELECT 
                                          CONCAT(SP.CODOFI, '-', SP.numvou) as numvou, 
                                          SP.BORRADO, 
                                          SP.documento, 
                                          dbo.getFechaInterfaz(R.fllega) AS fllega,
                                          SP.nompax, 
                                          PA.NOMPAQ,
                                          (SELECT S.nomser FROM SERVICIOS S where S.codser = T.codser) AS nomser, 
                                          dbo.getFechaInterfaz(T.FTOUR) AS ftour, 
                                          SUBSTRING(Convert(varchar, T.FTOUR, 108),1,5) AS htour, 
                                          U.NOMUBI, 
                                          SP.codnac, 
                                          SP.numpax,  
                                          SP.NUMPAX1 AS ADULTOS,
                                          SP.NUMPAX2 AS INFANTES,
                                          T.LUGAR, 
                                          (select P.NOMPRO from PROVEEDORES P where P.CODPRO = T.CODPRO) as nompro, 
                                          C.NOMCLI, 
                                          R.ASESORAGE, 
                                          R.VOUCHER, 
                                          SP.codusr, 
                                          dbo.getFechaInterfaz(SP.fdigita) AS fdigita,
                                          SP.obs, 
                                          case ISNULL(SP.BORRADO,'NO') 
                                          when 'SI' THEN (select 
                                                            ISNULL(max(dbo.getFechaInterfaz(l.fecha)),dbo.getFechaInterfaz(SP.fdigita))
                                                          from LOGS l
                                                          where l.TABLA = 'TOUR'
                                                          and l.TIPO = 'ANU'
                                                          and l.NUM = SP.NUMVOU)
                                          ELSE '' END AS fechaAnula, 
                                          case ISNULL(SP.BORRADO,'NO') 
                                          when 'SI' THEN (select 
                                                    ISNULL(max(l.CODUSR),SP.CODUSR)
                                                  from LOGS l
                                                  where l.TABLA = 'TOUR'
                                                  and l.TIPO = 'ANU'
                                                  and l.NUM = SP.NUMVOU)
                                          ELSE '' END AS usuarioAnula 
                                        FROM SERVICIOS_PARTICULAR SP, TOURS T, reservas R, clientes C, paquetes PA, ubicaciones U  
                                        WHERE  SP.codtour = T.codtour AND 
                                          CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento AND
                                          R.CODCLI = C.CODCLI AND 
                                          U.CODUBI = R.CODHOT AND  
                                          PA.CODPAQ = R.CODPAQ AND 
                                          T.codser like '#p3' AND 
                                          T.codpro like '#p4' AND 
                                          CONVERT(varchar, SP.fdigita, 112) >= '#p1' AND 
                                          CONVERT(varchar, SP.fdigita, 112) <= '#p2' AND 
                                          SUBSTRING(CONVERT(varchar, T.FTOUR, 108),1,5) LIKE '#p5' AND
                                          SP.CODOFI LIKE '#p7' AND
                                          R.CODPAQ LIKE '#p8' 
                                        ORDER BY numvou";	

$query["queryConsecutivoVentaTour2"] =  "SELECT 
                                          CONCAT(SP.CODOFI, '-', SP.numvou) as numvou, 
                                          SP.BORRADO, 
                                          SP.documento, 
                                          dbo.getFechaInterfaz(R.fllega) AS fllega,
                                          SP.nompax, 
                                          PA.NOMPAQ,
                                          (SELECT S.nomser FROM SERVICIOS S where S.codser = T.codser) AS nomser, 
                                          dbo.getFechaInterfaz(T.FTOUR) AS ftour, 
                                          SUBSTRING(Convert(varchar, T.FTOUR, 108),1,5) AS htour, 
                                          U.NOMUBI, 
                                          SP.codnac, 
                                          SP.numpax,  
                                          SP.NUMPAX1 AS ADULTOS,
                                          SP.NUMPAX2 AS INFANTES,
                                          T.LUGAR, 
                                          (select P.NOMPRO from PROVEEDORES P where P.CODPRO = T.CODPRO) as nompro, 
                                          C.NOMCLI, 
                                          R.ASESORAGE, 
                                          R.VOUCHER, 
                                          SP.codusr, 
                                          dbo.getFechaInterfaz(SP.fdigita) AS fdigita,
                                          SP.obs, 
                                          case ISNULL(SP.BORRADO,'NO') 
                                          when 'SI' THEN (select 
                                                            ISNULL(max(dbo.getFechaInterfaz(l.fecha)),dbo.getFechaInterfaz(SP.fdigita))
                                                          from LOGS l
                                                          where l.TABLA = 'TOUR'
                                                          and l.TIPO = 'ANU'
                                                          and l.NUM = SP.NUMVOU)
                                          ELSE '' END AS fechaAnula, 
                                          case ISNULL(SP.BORRADO,'NO') 
                                          when 'SI' THEN (select 
                                                    ISNULL(max(l.CODUSR),SP.CODUSR)
                                                  from LOGS l
                                                  where l.TABLA = 'TOUR'
                                                  and l.TIPO = 'ANU'
                                                  and l.NUM = SP.NUMVOU)
                                          ELSE '' END AS usuarioAnula 
                                        FROM SERVICIOS_PARTICULAR SP, TOURS T, reservas R, clientes C, paquetes PA, ubicaciones U  
                                        WHERE  SP.codtour = T.codtour AND 
                                          CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento AND
                                          R.CODCLI = C.CODCLI AND 
                                          U.CODUBI = R.CODHOT AND  
                                          PA.CODPAQ = R.CODPAQ AND 
                                          T.codser like '#p3' AND 
                                          T.codpro like '#p4' AND 
                                          CONVERT(varchar, R.fllega, 112) >= '#p1' AND 
                                          CONVERT(varchar, R.fllega, 112) <= '#p2' AND 
                                          SUBSTRING(CONVERT(varchar, T.FTOUR, 108),1,5) LIKE '#p5' AND
                                          SP.CODOFI LIKE '#p7' AND
                                          R.CODPAQ LIKE '#p8' 
                                        ORDER BY numvou";	
                                        
$query["queryConsecutivoVentaTourAge"] =  "SELECT 
                                            CONCAT(SP.CODOFI, '-', SP.numvou) as numvou, 
                                            SP.BORRADO, 
                                            SP.documento, 
                                            dbo.getFechaInterfaz(R.fllega) AS fllega, 
                                            SP.nompax,
                                            PA.NOMPAQ,
                                            (SELECT S.nomser FROM SERVICIOS S where S.codser = T.codser) AS nomser, 
                                            dbo.getFechaInterfaz(T.FTOUR) AS ftour, 
                                            SUBSTRING(Convert(varchar, T.FTOUR, 108),1,5) AS htour, 
                                            U.NOMUBI, 
                                            SP.codnac, 
                                            SP.numpax,  
                                            SP.NUMPAX1 AS ADULTOS,
                                            SP.NUMPAX2 AS INFANTES,
                                            T.LUGAR, 
                                            (select P.NOMPRO from PROVEEDORES P where P.CODPRO = T.CODPRO) as nompro, 
                                            C.NOMCLI, 
                                            R.ASESORAGE, 
                                            R.VOUCHER, 
                                            SP.codusr, 
                                            dbo.getFechaInterfaz(SP.fdigita) AS fdigita,
                                            SP.obs, 
                                            case ISNULL(SP.BORRADO,'NO') 
                                            when 'SI' THEN (select 
                                                              ISNULL(max(dbo.getFechaInterfaz(l.fecha)),dbo.getFechaInterfaz(SP.fdigita))
                                                            from LOGS l
                                                            where l.TABLA = 'TOUR'
                                                            and l.TIPO = 'ANU'
                                                            and l.NUM = SP.NUMVOU)
                                            ELSE '' END AS fechaAnula, 
                                            case ISNULL(SP.BORRADO,'NO') 
                                            when 'SI' THEN (select 
                                                      ISNULL(max(l.CODUSR),SP.CODUSR)
                                                    from LOGS l
                                                    where l.TABLA = 'TOUR'
                                                    and l.TIPO = 'ANU'
                                                    and l.NUM = SP.NUMVOU)
                                            ELSE '' END AS usuarioAnula 
                                          FROM SERVICIOS_PARTICULAR SP, TOURS T, reservas R, clientes C, paquetes PA, UBICACIONES U    
                                          WHERE  SP.codtour = T.codtour AND 
                                            T.codser like '#p3' AND 
                                            T.codpro like '#p4' AND 
                                            PA.CODPAQ = R.CODPAQ AND 
                                            CONVERT(varchar, SP.fdigita, 112) >= '#p1' AND 
                                            CONVERT(varchar, SP.fdigita, 112) <= '#p2' AND 
                                            SUBSTRING(CONVERT(varchar, T.FTOUR, 108),1,5) LIKE '#p5' AND 
                                            SP.tipo = 'Plan' AND 
                                            CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento AND 
                                            R.CODCLI = '#p6' AND 
                                            R.CODCLI = C.CODCLI AND 
                                            U.CODUBI = R.CODHOT AND 
                                            SP.CODOFI LIKE '#p7' AND
                                            R.CODPAQ LIKE '#p8' 
                                          ORDER BY numvou";	                  

$query["queryConsecutivoVentaTourAge2"] =  "SELECT 
                                            CONCAT(SP.CODOFI, '-', SP.numvou) as numvou, 
                                            SP.BORRADO, 
                                            SP.documento, 
                                            dbo.getFechaInterfaz(R.fllega) AS fllega, 
                                            SP.nompax,
                                            PA.NOMPAQ,
                                            (SELECT S.nomser FROM SERVICIOS S where S.codser = T.codser) AS nomser, 
                                            dbo.getFechaInterfaz(T.FTOUR) AS ftour, 
                                            SUBSTRING(Convert(varchar, T.FTOUR, 108),1,5) AS htour, 
                                            U.NOMUBI, 
                                            SP.codnac, 
                                            SP.numpax,  
                                            SP.NUMPAX1 AS ADULTOS,
                                            SP.NUMPAX2 AS INFANTES,
                                            T.LUGAR, 
                                            (select P.NOMPRO from PROVEEDORES P where P.CODPRO = T.CODPRO) as nompro, 
                                            C.NOMCLI, 
                                            R.ASESORAGE, 
                                            R.VOUCHER, 
                                            SP.codusr, 
                                            dbo.getFechaInterfaz(SP.fdigita) AS fdigita,
                                            SP.obs, 
                                            case ISNULL(SP.BORRADO,'NO') 
                                            when 'SI' THEN (select 
                                                              ISNULL(max(dbo.getFechaInterfaz(l.fecha)),dbo.getFechaInterfaz(SP.fdigita))
                                                            from LOGS l
                                                            where l.TABLA = 'TOUR'
                                                            and l.TIPO = 'ANU'
                                                            and l.NUM = SP.NUMVOU)
                                            ELSE '' END AS fechaAnula, 
                                            case ISNULL(SP.BORRADO,'NO') 
                                            when 'SI' THEN (select 
                                                      ISNULL(max(l.CODUSR),SP.CODUSR)
                                                    from LOGS l
                                                    where l.TABLA = 'TOUR'
                                                    and l.TIPO = 'ANU'
                                                    and l.NUM = SP.NUMVOU)
                                            ELSE '' END AS usuarioAnula 
                                          FROM SERVICIOS_PARTICULAR SP, TOURS T, reservas R, clientes C, paquetes PA, UBICACIONES U    
                                          WHERE  SP.codtour = T.codtour AND 
                                            T.codser like '#p3' AND 
                                            T.codpro like '#p4' AND 
                                            PA.CODPAQ = R.CODPAQ AND 
                                            CONVERT(varchar, R.fllega, 112) >= '#p1' AND 
                                            CONVERT(varchar, R.fllega, 112) <= '#p2' AND 
                                            SUBSTRING(CONVERT(varchar, T.FTOUR, 108),1,5) LIKE '#p5' AND 
                                            SP.tipo = 'Plan' AND 
                                            CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento AND 
                                            R.CODCLI = '#p6' AND 
                                            R.CODCLI = C.CODCLI AND 
                                            U.CODUBI = R.CODHOT AND 
                                            SP.CODOFI LIKE '#p7' AND
                                            R.CODPAQ LIKE '#p8' 
                                          ORDER BY numvou";
                                          
                                          
$query["queryRepContactos"] = "SELECT 
								documento,
								nombre,
								celular,
								email, 
								dbo.getFechaInterfaz(ultimacompra) AS ultimacompra
								FROM CONTACTOS 
								WHERE  CONVERT(varchar, ultimacompra, 112) >= '#p1' AND 
								CONVERT(varchar, ultimacompra, 112) <= '#p2'
								ORDER BY documento";	

$query["queryConsolidadoTours1"] =  "SELECT 
                                        SP.numvou,
                                        SP.documento, 
                                        SP.tipo, 
                                        SP.nompax, 
                                        (SELECT S.nomser FROM SERVICIOS S where S.codser = T.codser) AS nomser, 
                                        dbo.getFechaInterfaz(T.FTOUR) AS ftour, 
                                        SP.NUMPAX1 AS ADULTOS,
                                        CASE WHEN SP.NUMPAX1 > 0 THEN SP.PRECIOXPER ELSE 0 END AS PRECADUL,
										SP.NUMPAX2 AS INFANTES,
										CASE WHEN SP.NUMPAX2 > 0 THEN SP.PRECIOXPER2 ELSE 0 END AS PRECINF,
										SP.numpax,  
                                        dbo.getValorConPuntos(SP.total) AS total, 	
										dbo.getFechaInterfaz(SP.fdigita) AS fdigita, 									
                                        (select C.NOMCLI 
                                        from reservas R, clientes C 
                                        where R.CODCLI = C.CODCLI 
                                        and CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento) as nomcli, 
										(select P.NOMPRO from PROVEEDORES P where P.CODPRO = T.CODPRO) as nompro
									FROM SERVICIOS_PARTICULAR SP, TOURS T 
									WHERE  SP.codtour = T.codtour AND 
									SP.BORRADO IS NULL AND 
									CONVERT(varchar, T.FTOUR, 112) >= '#p1' AND 
									CONVERT(varchar, T.FTOUR, 112) <= '#p2' AND 
									T.codser like '#p3'
									ORDER BY numvou";

$query["queryConsolidadoTours2"] =  "SELECT 
										SP.numvou,
										SP.documento, 
										SP.tipo, 
										SP.nompax, 
										(SELECT S.nomser FROM SERVICIOS S where S.codser = T.codser) AS nomser, 
										dbo.getFechaInterfaz(T.FTOUR) AS ftour, 
										SP.NUMPAX1 AS ADULTOS,
										CASE WHEN SP.NUMPAX1 > 0 THEN SP.PRECIOXPER ELSE 0 END AS PRECADUL,
										SP.NUMPAX2 AS INFANTES,
										CASE WHEN SP.NUMPAX2 > 0 THEN SP.PRECIOXPER2 ELSE 0 END AS PRECINF,
										SP.numpax,  
										dbo.getValorConPuntos(SP.total) AS total, 	
										dbo.getFechaInterfaz(SP.fdigita) AS fdigita,
										(select C.NOMCLI 
										from reservas R, clientes C 
										where R.CODCLI = C.CODCLI 
										and CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento) as nomcli,
										(select P.NOMPRO from PROVEEDORES P where P.CODPRO = T.CODPRO) as nompro
									FROM SERVICIOS_PARTICULAR SP, TOURS T, RESERVAS R
									WHERE  SP.codtour = T.codtour AND 
										SP.BORRADO IS NULL AND 
										CONVERT(varchar, T.FTOUR, 112) >= '#p1' AND 
										CONVERT(varchar, T.FTOUR, 112) <= '#p2' AND 
										T.codser like '#p3' AND
										R.NUMRES = SUBSTRING(SP.documento, 1, (CHARINDEX('-', SP.documento)-1)) AND
										R.RESRES = SUBSTRING(SP.documento, (CHARINDEX('-', SP.documento)+1), 10) AND
										SP.tipo = 'Plan' AND
										sp.documento is not null AND 
										LEN(sp.documento) > 0 AND 
										R.CODCLI = '#p4'
									ORDER BY numvou";                      

$query["queryProgramacionTour"] = "SELECT T.CODTOUR, 
									(SELECT S.nomser FROM SERVICIOS S where S.codser = T.codser) AS nomser, 
									dbo.getFechaInterfaz(T.ftour) AS fectour, 
									SUBSTRING(Convert(varchar, T.ftour, 108),1,5) AS hortour, 
									T.lugar, 
									(SELECT P.nompro FROM PROVEEDORES P where P.codpro = T.codpro) AS codpro, 
									case T.cupos when 0 then 'Ilimitado' else CAST (T.cupos AS varchar) end as cupos, 
									(SELECT isnull(SUM(SP.NUMPAX),0) FROM SERVICIOS_PARTICULAR SP WHERE SP.CODTOUR = T.CODTOUR AND SP.BORRADO IS NULL) as cupos_ven, 
									case T.cupos when 0 then 'Ilimitado' else CAST ((T.cupos - (SELECT isnull(SUM(SP.NUMPAX),0) FROM SERVICIOS_PARTICULAR SP WHERE SP.CODTOUR = T.CODTOUR AND SP.BORRADO IS NULL)) AS varchar) end as cupos_disp 
									FROM TOURS T 
									WHERE T.codser like '#p1' AND 
									CONVERT(varchar, T.FTOUR, 112) >= '#p2' AND 
									CONVERT(varchar, T.FTOUR, 112) <= '#p3' AND 
									T.borrado is null 
									ORDER BY T.ftour";

$query["queryTourXCod"] = "SELECT CODTOUR, 
							CODSER, 
							dbo.getFechaInterfaz(FTOUR) AS FTOUR, 
							SUBSTRING(Convert(varchar, FTOUR, 108),1,5) AS HTOUR, 
							LUGAR, 
							CODPRO,
							CUPOS 
							FROM TOURS 
							WHERE CODTOUR = '#p1' AND BORRADO IS NULL";
							
$query["queryCuposOcuTour"] = "SELECT ISNULL(SUM(NUMPAX),0) FROM SERVICIOS_PARTICULAR WHERE CODTOUR = '#p1' AND BORRADO IS NULL";

$query["queryPasajerosTour"] = "SELECT 
                                NUMVOU, 
                                case tipo 
                                  when 'Plan' then NOMPAX+' X '+cast(numpax AS VARCHAR)+' - Reserva: '+documento+' - Vou: '+codofi+'-'+cast(NUMVOU AS VARCHAR)
                                  else NOMPAX+' - Doc: '+documento 
                                end as nompax 
                                FROM SERVICIOS_PARTICULAR 
                                WHERE CODTOUR = '#p1' 
                                AND CODOFI = '#p2' 
                                AND BORRADO IS NULL";						

$query["queryPaxTour"] = "SELECT NUMVOU, NOMPAX, NUMPAX FROM SERVICIOS_PARTICULAR WHERE NUMVOU = '#p1' AND BORRADO IS NULL";	
						
$query["queryInfoVoucher"] = "SELECT 
                                  CONCAT(sp.codofi, '-', sp.numvou) AS voucher, 
                                  r.numres,
                                  sp.nompax, 
                                  sp.numpax, 
                                  c.nomcli,
                                  s.nomser,
                                  dbo.getFechaInterfaz(T.FTOUR) AS ftour, 
                                  SUBSTRING(Convert(varchar, T.FTOUR, 108),1,5) AS htour
                               FROM servicios_particular sp, reservas R, CLIENTES C, tours t, servicios s 
                               WHERE sp.NUMVOU = '#p1' 
                                AND SP.CODOFI = '#p2'
                                AND CAST(R.numres AS varchar(30))+'-'+CAST(R.resres AS varchar(30)) = SP.documento 
                                AND R.CODCLI = C.CODCLI
                                AND t.codtour = sp.codtour
                                AND s.codser = t.codser";							

$query["queryEstadisticaNacRangoAge"] = "SELECT (SELECT C.NOMCLI FROM CLIENTES C WHERE C.CODCLI = R.CODCLI) as CLI, 
										dbo.getValorConPuntos(SUM(R.numpax)) as totpax 
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										R.CODNAC = '#p1' AND 
										CONVERT(varchar, fllega, 112) >= '#p2' AND 
										CONVERT(varchar, fllega, 112) <= '#p3' 
										GROUP BY R.CODCLI";								

$query["queryEstadisticaNacRangoHot"] = "SELECT (SELECT U.NOMUBI FROM UBICACIONES U WHERE U.CODUBI = R.CODHOT) as HOT, 
										dbo.getValorConPuntos(SUM(R.numpax)) as totpax 
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										R.CODNAC = '#p1' AND 
										CONVERT(varchar, fllega, 112) >= '#p2' AND 
										CONVERT(varchar, fllega, 112) <= '#p3' 
										GROUP BY R.CODHOT";

$query["queryEstadisticaNacRangoSer"] = "SELECT * FROM 
										( 
										SELECT S.NOMSER,  
										(SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										R.CODNAC = '#p1' AND 
										CONVERT(varchar, R.fllega, 112) >= '#p2' AND 
										CONVERT(varchar, R.fllega, 112) <= '#p3' AND 
										CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
										) AS NUM 
										FROM SERVICIOS S WHERE S.TIPO IS NULL 
										) T 
										WHERE T.NUM IS NOT NULL";

$query["queryEstadisticaNacMensualAge"] = "SELECT C.NOMCLI, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.01','.','') AND 
											R.CODCLI = C.CODCLI), 0) AS ENE, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.02','.','') AND 
											R.CODCLI = C.CODCLI), 0) AS FEB, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.03','.','') AND 
											R.CODCLI = C.CODCLI), 0) AS MAR, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.04','.','') AND 
											R.CODCLI = C.CODCLI), 0) AS ABR, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.05','.','') AND 
											R.CODCLI = C.CODCLI), 0) AS MAY, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.06','.','') AND 
											R.CODCLI = C.CODCLI), 0) AS JUN,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.07','.','') AND 
											R.CODCLI = C.CODCLI), 0) AS JUL,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.08','.','') AND 
											R.CODCLI = C.CODCLI), 0) AS AGO,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.09','.','') AND 
											R.CODCLI = C.CODCLI), 0) AS SEP,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.10','.','') AND 
											R.CODCLI = C.CODCLI), 0) AS OCT,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.11','.','') AND 
											R.CODCLI = C.CODCLI), 0) AS NOV,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.12','.','') AND 
											R.CODCLI = C.CODCLI), 0) AS DIC
											FROM CLIENTES C WHERE TIPOCLI = 'AG'";

$query["queryEstadisticaNacMensualHot"] = "SELECT U.NOMUBI, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.01','.','') AND 
											R.CODHOT = U.CODUBI), 0) AS ENE, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.02','.','') AND 
											R.CODHOT = U.CODUBI), 0) AS FEB, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.03','.','') AND 
											R.CODHOT = U.CODUBI), 0) AS MAR, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.04','.','') AND 
											R.CODHOT = U.CODUBI), 0) AS ABR, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.05','.','') AND 
											R.CODHOT = U.CODUBI), 0) AS MAY, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.06','.','') AND 
											R.CODHOT = U.CODUBI), 0) AS JUN,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.07','.','') AND 
											R.CODHOT = U.CODUBI), 0) AS JUL,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.08','.','') AND 
											R.CODHOT = U.CODUBI), 0) AS AGO,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.09','.','') AND 
											R.CODHOT = U.CODUBI), 0) AS SEP,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.10','.','') AND 
											R.CODHOT = U.CODUBI), 0) AS OCT,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.11','.','') AND 
											R.CODHOT = U.CODUBI), 0) AS NOV,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.12','.','') AND 
											R.CODHOT = U.CODUBI), 0) AS DIC
											FROM UBICACIONES U WHERE TIPOUBI = 'HOT'";

$query["queryEstadisticaNacMensualSer"] = "SELECT S.NOMSER,  
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.01','.','') AND 
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
											), 0) AS ENE, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.02','.','') AND 
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
											), 0) AS FEB, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.03','.','') AND 
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
											), 0) AS MAR, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.04','.','') AND 
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
											), 0) AS ABR, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.05','.','') AND 
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
											), 0) AS MAY, 
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.06','.','') AND 
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
											), 0) AS JUN,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.07','.','') AND 
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
											), 0) AS JUL,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.08','.','') AND 
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
											), 0) AS AGO,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.09','.','') AND 
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
											), 0) AS SEP,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.10','.','') AND 
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
											), 0) AS OCT,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.11','.','') AND 
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
											), 0) AS NOV,
											ISNULL((SELECT dbo.getValorConPuntos(SUM(R.NUMPAX)) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.12','.','') AND 
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = S.CODSER) 
											), 0) AS DIC
											FROM SERVICIOS S WHERE S.TIPO IS NULL";
										
$query["queryEstadisticaSerRangoNac"] = "(SELECT (SELECT N.NACIONAL FROM NACIONALIDADES N WHERE N.CODNAC = R.CODNAC) AS NAC, SUM(R.NUMPAX) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										CONVERT(varchar, R.fllega, 112) >= '#p2' AND 
										CONVERT(varchar, R.fllega, 112) <= '#p3' AND
										CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
										GROUP BY CODNAC
										)";

$query["queryEstadisticaSerMensualNac"] = "SELECT N.NACIONAL,
											ISNULL((SELECT SUM(R.NUMPAX) AS NUMPAX
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = N.CODNAC AND
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.01','.','') AND
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
											), 0) AS ENE,
											ISNULL((SELECT SUM(R.NUMPAX) AS NUMPAX
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = N.CODNAC AND
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.02','.','') AND
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
											), 0) AS FEB,
											ISNULL((SELECT SUM(R.NUMPAX) AS NUMPAX
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = N.CODNAC AND
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.03','.','') AND
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
											), 0) AS MAR,
											ISNULL((SELECT SUM(R.NUMPAX) AS NUMPAX
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = N.CODNAC AND
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.04','.','') AND
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
											), 0) AS ABR,
											ISNULL((SELECT SUM(R.NUMPAX) AS NUMPAX
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = N.CODNAC AND
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.05','.','') AND
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
											), 0) AS MAY,
											ISNULL((SELECT SUM(R.NUMPAX) AS NUMPAX
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = N.CODNAC AND
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.06','.','') AND
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
											), 0) AS JUN,
											ISNULL((SELECT SUM(R.NUMPAX) AS NUMPAX
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = N.CODNAC AND
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.07','.','') AND
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
											), 0) AS JUL,
											ISNULL((SELECT SUM(R.NUMPAX) AS NUMPAX
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = N.CODNAC AND
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.08','.','') AND
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
											), 0) AS AGO,
											ISNULL((SELECT SUM(R.NUMPAX) AS NUMPAX
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = N.CODNAC AND
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.09','.','') AND
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
											), 0) AS SEP,
											ISNULL((SELECT SUM(R.NUMPAX) AS NUMPAX
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = N.CODNAC AND
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.10','.','') AND
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
											), 0) AS OCT,
											ISNULL((SELECT SUM(R.NUMPAX) AS NUMPAX
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = N.CODNAC AND
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.11','.','') AND
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
											), 0) AS NOV,
											ISNULL((SELECT SUM(R.NUMPAX) AS NUMPAX
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODNAC = N.CODNAC AND
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.12','.','') AND
											CAST(R.NUMRES AS VARCHAR(10))+'-'+CAST(R.RESRES AS VARCHAR(10)) IN (SELECT CAST(SP.NUMRES AS VARCHAR(10))+'-'+CAST(SP.RESRES AS VARCHAR(10)) FROM RESERVAS_TOUR SP WHERE SP.CODSER = '#p1')
											), 0) AS DIC
											FROM NACIONALIDADES N";
										
$query["queryEstadisticaHotRangoAge"] = "(SELECT (SELECT C.NOMCLI FROM CLIENTES C WHERE C.CODCLI = R.CODCLI) AS AGE, SUM(R.NUMPAX) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										R.CODHOT = '#p1' AND
										CONVERT(varchar, R.fllega, 112) >= '#p2' AND 
										CONVERT(varchar, R.fllega, 112) <= '#p3'
										GROUP BY CODCLI
										)";

$query["queryEstadisticaHotRangoNac"] = "(SELECT (SELECT N.NACIONAL FROM NACIONALIDADES N WHERE N.CODNAC = R.CODNAC) AS NAC, SUM(R.NUMPAX) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										R.CODHOT = '#p1' AND
										CONVERT(varchar, R.fllega, 112) >= '#p2' AND 
										CONVERT(varchar, R.fllega, 112) <= '#p3'
										GROUP BY CODNAC
										)";
										
$query["queryEstadisticaHotMensualAge"] = "SELECT C.NOMCLI,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.01','.','') AND
											R.CODCLI = C.CODCLI), 0) AS ENE,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.02','.','') AND
											R.CODCLI = C.CODCLI), 0) AS FEB,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.03','.','') AND
											R.CODCLI = C.CODCLI), 0) AS MAR,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.04','.','') AND
											R.CODCLI = C.CODCLI), 0) AS ABR,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.05','.','') AND
											R.CODCLI = C.CODCLI), 0) AS MAY,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.06','.','') AND
											R.CODCLI = C.CODCLI), 0) AS JUN,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.07','.','') AND
											R.CODCLI = C.CODCLI), 0) AS JUL,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.08','.','') AND
											R.CODCLI = C.CODCLI), 0) AS AGO,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.09','.','') AND
											R.CODCLI = C.CODCLI), 0) AS SEP,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.10','.','') AND
											R.CODCLI = C.CODCLI), 0) AS OCT,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.11','.','') AND
											R.CODCLI = C.CODCLI), 0) AS NOV,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.12','.','') AND
											R.CODCLI = C.CODCLI), 0) AS DIC
											FROM CLIENTES C WHERE TIPOCLI = 'AG'";	
										
$query["queryEstadisticaHotMensualNac"] = "SELECT N.NACIONAL,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.01','.','') AND
											R.CODNAC = N.CODNAC), 0) AS ENE,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.02','.','') AND
											R.CODNAC = N.CODNAC), 0) AS FEB,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.03','.','') AND
											R.CODNAC = N.CODNAC), 0) AS MAR,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.04','.','') AND
											R.CODNAC = N.CODNAC), 0) AS ABR,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.05','.','') AND
											R.CODNAC = N.CODNAC), 0) AS MAY,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.06','.','') AND
											R.CODNAC = N.CODNAC), 0) AS JUN,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.07','.','') AND
											R.CODNAC = N.CODNAC), 0) AS JUL,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.08','.','') AND
											R.CODNAC = N.CODNAC), 0) AS AGO,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.09','.','') AND
											R.CODNAC = N.CODNAC), 0) AS SEP,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.10','.','') AND
											R.CODNAC = N.CODNAC), 0) AS OCT,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.11','.','') AND
											R.CODNAC = N.CODNAC), 0) AS NOV,
											ISNULL((SELECT SUM(R.NUMPAX)
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.CODHOT = '#p1' AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p2.12','.','') AND
											R.CODNAC = N.CODNAC), 0) AS DIC
											FROM NACIONALIDADES N";										

$query["queryEstadisticaResRango"] = "(SELECT SUM(R.NUMPAX) AS NUMPAX
									FROM RESERVAS R 
									WHERE BORRADA IS NULL AND 
									CONVERT(varchar, R.fllega, 112) >= '#p1' AND 
									CONVERT(varchar, R.fllega, 112) <= '#p2'
									)";

$query["queryEstadisticaResMensual"] = "SELECT T.MES, T.NUMPAX FROM
										(
										(SELECT '01' AS NROMES, 'ENE' AS MES, ISNULL(SUM(R.NUMPAX), 0) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.01','.',''))
										UNION
										(SELECT '02' AS NROMES, 'FEB' AS MES, ISNULL(SUM(R.NUMPAX), 0) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.02','.',''))
										UNION
										(SELECT '03' AS NROMES, 'MAR' AS MES, ISNULL(SUM(R.NUMPAX), 0) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.03','.',''))
										UNION
										(SELECT '04' AS NROMES, 'ABR' AS MES, ISNULL(SUM(R.NUMPAX), 0) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.04','.',''))
										UNION
										(SELECT '05' AS NROMES, 'MAY' AS MES, ISNULL(SUM(R.NUMPAX), 0) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.05','.',''))
										UNION
										(SELECT '06' AS NROMES, 'JUN' AS MES, ISNULL(SUM(R.NUMPAX), 0) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.06','.',''))
										UNION
										(SELECT '07' AS NROMES, 'JUL' AS MES, ISNULL(SUM(R.NUMPAX), 0) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.07','.',''))
										UNION
										(SELECT '08' AS NROMES, 'AGO' AS MES, ISNULL(SUM(R.NUMPAX), 0) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.08','.',''))
										UNION
										(SELECT '09' AS NROMES, 'SEP' AS MES, ISNULL(SUM(R.NUMPAX), 0) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.09','.',''))
										UNION
										(SELECT '10' AS NROMES, 'OCT' AS MES, ISNULL(SUM(R.NUMPAX), 0) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.10','.',''))
										UNION
										(SELECT '11' AS NROMES, 'NOV' AS MES, ISNULL(SUM(R.NUMPAX), 0) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.11','.',''))
										UNION
										(SELECT '12' AS NROMES, 'DIC' AS MES, ISNULL(SUM(R.NUMPAX), 0) AS NUMPAX
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.12','.',''))
										) AS T
										ORDER BY T.NROMES";

$query["queryEstadisticaPaxAgeRango"] = "SELECT C.NOMCLI, 
										(SELECT ISNULL(SUM(R.NUMPAX), 0) 
										FROM RESERVAS R 
										WHERE BORRADA IS NULL AND 
										R.codcli = C.CODCLI AND 
										CONVERT(varchar, R.fllega, 112) >= '#p1' AND 
										CONVERT(varchar, R.fllega, 112) <= '#p2') AS NUMPAX 
										FROM CLIENTES C 
										WHERE C.TIPOCLI = 'AG' 
										ORDER BY C.NOMCLI";
										
$query["queryEstadisticaPaxAgeMensual"] = "SELECT C.NOMCLI, 
											(SELECT ISNULL(SUM(R.NUMPAX), 0) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.codcli = C.CODCLI AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.01','.','')) AS ENE,
											(SELECT ISNULL(SUM(R.NUMPAX), 0) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.codcli = C.CODCLI AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.02','.','')) AS FEB,
											(SELECT ISNULL(SUM(R.NUMPAX), 0) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.codcli = C.CODCLI AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.03','.','')) AS MAR,
											(SELECT ISNULL(SUM(R.NUMPAX), 0) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.codcli = C.CODCLI AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.04','.','')) AS ABR,
											(SELECT ISNULL(SUM(R.NUMPAX), 0) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.codcli = C.CODCLI AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.05','.','')) AS MAY,
											(SELECT ISNULL(SUM(R.NUMPAX), 0) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.codcli = C.CODCLI AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.06','.','')) AS JUN,
											(SELECT ISNULL(SUM(R.NUMPAX), 0) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.codcli = C.CODCLI AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.07','.','')) AS JUL,
											(SELECT ISNULL(SUM(R.NUMPAX), 0) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.codcli = C.CODCLI AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.08','.','')) AS AGO,
											(SELECT ISNULL(SUM(R.NUMPAX), 0) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.codcli = C.CODCLI AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.09','.','')) AS SEP,
											(SELECT ISNULL(SUM(R.NUMPAX), 0) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.codcli = C.CODCLI AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.10','.','')) AS OCT,
											(SELECT ISNULL(SUM(R.NUMPAX), 0) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.codcli = C.CODCLI AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.11','.','')) AS NOV,
											(SELECT ISNULL(SUM(R.NUMPAX), 0) 
											FROM RESERVAS R 
											WHERE BORRADA IS NULL AND 
											R.codcli = C.CODCLI AND 
											SUBSTRING(CONVERT(varchar, R.fllega, 112),1,6) = REPLACE('#p1.12','.','')) AS DIC
											FROM CLIENTES C 
											WHERE C.TIPOCLI = 'AG' 
											ORDER BY C.NOMCLI";										
									
/*---------------------------------------------------I N S E R T S---------------------------------------------*/
$query["insertReserva"] = "INSERT INTO RESERVAS (FDIGITA, NUMRES, RESRES, FLLEGA, FSALE, 
									  CODCLI, NOMPAX, CODNAC, NUMPAX, VUELLE, 
									  CODHOT, VUESAL, CODUSR, OBS, BORRADA, 
                    VOUCHER, TELPAX, DOCUMENTO, CODOFI, HORALLE, 
                    HORASAL, CODPAQ, ASESORAGE) 
									  VALUES (#p1, '#p2', '#p3', #p4, #p5, 
									  '#p6', '#p7', '#p8', '#p9', '#p10', 
									  '#p11', '#p12', '#p13', '#p14', #p15, 
                    '#p16', '#p17', '#p18', '#p19', '#p20', 
                    '#p21', '#p22', '#p23')";
									  
$query["insertServicioReserva"] = "INSERT INTO RESERVAS_TOUR (NUMRES, RESRES, CODSER, CODUSR, FDIGITA)  
										VALUES ('#p1', '#p2', '#p3', '#p4', #p5)";

$query["insertRespaldoReserva"] = "INSERT INTO RESERVAS (FDIGITA, NUMRES, RESRES, FLLEGA, FSALE, 
                                                        CODCLI, NOMPAX, CODNAC, NUMPAX, VUELLE, 
                                                        CODHOT, VUESAL, CODUSR, OBS, BORRADA, 
                                                        VOUCHER, TELPAX, DOCUMENTO, CODOFI, HORALLE, 
                                                        HORASAL, CODPAQ, ASESORAGE) 
                                                        (SELECT 
                                                            FDIGITA, (NUMRES*(-1)) AS NUMRES, RESRES, FLLEGA, FSALE, 
                                                            CODCLI, NOMPAX, CODNAC, NUMPAX, VUELLE, 
                                                            CODHOT, VUESAL, CODUSR, OBS, BORRADA, 
                                                            VOUCHER, TELPAX, DOCUMENTO, CODOFI, HORALLE, 
                                                            HORASAL, CODPAQ, ASESORAGE 
                                                        FROM RESERVAS WHERE NUMRES = '#p1')";

$query["insertCliente"] = "INSERT INTO CLIENTES (	CODCLI, NOMCLI, DIRCLI, CIUCLI, 
									TE1CLI, TE2CLI, CELCLI, CONCLI, TIPOCLI, NITCLI) 
									VALUES 
									('#p1', '#p2', '#p3', '#p4', 
									'#p5', '#p6', '#p7', '#p8', '#p9', '#p10')";

$query["insertServicio"] = "INSERT INTO SERVICIOS (CODSER, NOMSER, SELDEFECTO, ORDENSALE, TIPO, PRECIOADU, PRECIOINF) VALUES ('#p1', '#p2', '#p3', '#p4', NULL, '#p5', '#p6')";
									
$query["insertUbicacion"] = "INSERT INTO UBICACIONES 
                              (CODUBI, TIPOUBI, NOMUBI, DIRUBI, TE1UBI, TE2UBI, CELUBI, CONUBI, CODOFI) 
                              VALUES 
                              ('#p1', '#p8', '#p2', '#p3', '#p4', '#p5', '#p6', '#p7', '#p9')";

$query["insertUsuario"] = "INSERT INTO USUARIOS (CODUSR, CLAVE, CODROL, NOMBRE, APELLIDOS, FDIGITA, CODUSRDIG, CODCLI) VALUES ('#p1', '#p2', '#p3', '#p4', '#p5', #p6, '#p7', #p8)";

$query["insertNacionalidad"] = "INSERT INTO NACIONALIDADES (CODNAC, NACIONAL) VALUES ('#p1', '#p2')";

$query["insertProveedor"] = "INSERT INTO PROVEEDORES (CODPRO, NOMPRO, DIRPRO, TE1PRO, TE2PRO, CELPRO, CONPRO) VALUES ('#p1', '#p2', '#p3', '#p4', '#p5' , '#p6', '#p7')";

$query["insertPaquete"] = "INSERT INTO PAQUETES (CODPAQ, NOMPAQ, DESCPAQ, CODOFI) VALUES ('#p1', '#p2', '#p3', '#p4')";
							
$query["insertVuelo"] = "INSERT INTO VUELOS (TIPOVLO, NROVLO, HORAVLO) VALUES ('#p1', '#p2', '#p3')";

$query["updateVuelo"] = "UPDATE VUELOS SET HORAVLO = '#p3' WHERE TIPOVLO = '#p1' AND NROVLO = '#p2'";

$query["insertConsecutivo"] = "INSERT INTO CONSECUTIVOS (TIPO, NUM, ESTADO) VALUES ('#p1', '#p2', '#p3')";

$query["insertConsecutivoRango"] = "INSERT INTO CONSECUTIVOS (TIPO, NUM, ESTADO) 
									SELECT '#p1', #p2, '#p3' UNION ALL SELECT '#p1', #p2+1, '#p3' UNION ALL SELECT '#p1', #p2+2, '#p3' UNION ALL SELECT '#p1', #p2+3, '#p3' UNION ALL SELECT '#p1', #p2+4, '#p3' UNION ALL 
									SELECT '#p1', #p2+5, '#p3' UNION ALL SELECT '#p1', #p2+6, '#p3' UNION ALL SELECT '#p1', #p2+7, '#p3' UNION ALL SELECT '#p1', #p2+8, '#p3' UNION ALL SELECT '#p1', #p2+9, '#p3' UNION ALL 
									SELECT '#p1', #p2+10, '#p3' UNION ALL SELECT '#p1', #p2+11, '#p3' UNION ALL SELECT '#p1', #p2+12, '#p3' UNION ALL SELECT '#p1', #p2+13, '#p3' UNION ALL SELECT '#p1', #p2+14, '#p3' UNION ALL 
									SELECT '#p1', #p2+15, '#p3' UNION ALL SELECT '#p1', #p2+16, '#p3' UNION ALL SELECT '#p1', #p2+17, '#p3' UNION ALL SELECT '#p1', #p2+18, '#p3' UNION ALL SELECT '#p1', #p2+19, '#p3' UNION ALL 
									SELECT '#p1', #p2+20, '#p3' UNION ALL SELECT '#p1', #p2+21, '#p3' UNION ALL SELECT '#p1', #p2+22, '#p3' UNION ALL SELECT '#p1', #p2+23, '#p3' UNION ALL SELECT '#p1', #p2+24, '#p3' UNION ALL 
									SELECT '#p1', #p2+25, '#p3' UNION ALL SELECT '#p1', #p2+26, '#p3' UNION ALL SELECT '#p1', #p2+27, '#p3' UNION ALL SELECT '#p1', #p2+28, '#p3' UNION ALL SELECT '#p1', #p2+29, '#p3' UNION ALL 
									SELECT '#p1', #p2+30, '#p3' UNION ALL SELECT '#p1', #p2+31, '#p3' UNION ALL SELECT '#p1', #p2+32, '#p3' UNION ALL SELECT '#p1', #p2+33, '#p3' UNION ALL SELECT '#p1', #p2+34, '#p3' UNION ALL 
									SELECT '#p1', #p2+35, '#p3' UNION ALL SELECT '#p1', #p2+36, '#p3' UNION ALL SELECT '#p1', #p2+37, '#p3' UNION ALL SELECT '#p1', #p2+38, '#p3' UNION ALL SELECT '#p1', #p2+39, '#p3' UNION ALL 
									SELECT '#p1', #p2+40, '#p3' UNION ALL SELECT '#p1', #p2+41, '#p3' UNION ALL SELECT '#p1', #p2+42, '#p3' UNION ALL SELECT '#p1', #p2+43, '#p3' UNION ALL SELECT '#p1', #p2+44, '#p3' UNION ALL 
									SELECT '#p1', #p2+45, '#p3' UNION ALL SELECT '#p1', #p2+46, '#p3' UNION ALL SELECT '#p1', #p2+47, '#p3' UNION ALL SELECT '#p1', #p2+48, '#p3' UNION ALL SELECT '#p1', #p2+49, '#p3'";

$query["insertLog"] = "INSERT INTO LOGS 
						(FECHA, CODUSR, TIPO, 
						TABLA, NUM, DESCRIPCION, CODOFI) 
						VALUES(	#p1, '#p2', '#p3', 
                    '#p4', #p5, '#p6', '#p7')";
								
$query["insertTour"] = "INSERT INTO TOURS (CODTOUR, CODSER, FTOUR, LUGAR, CODPRO, CUPOS, CODOFI) 
                        VALUES('#p1', '#p2', #p3, '#p4', '#p5', '#p6', '#p7')";

$query["deleteTour"] = "DELETE FROM TOURS WHERE CODTOUR= '#p1'";
							
$query["insertContacto"] = "INSERT INTO CONTACTOS (DOCUMENTO, NOMBRE, CELULAR, EMAIL, ULTIMACOMPRA) 
							VALUES('#p1', '#p2', '#p3', '#p4', CURRENT_TIMESTAMP)";

$query["queryContacto"] = "SELECT NOMBRE, CELULAR, EMAIL FROM CONTACTOS WHERE DOCUMENTO = '#p1'";

$query["updateContacto"] = "UPDATE CONTACTOS 
							SET NOMBRE = '#p2',
							CELULAR = '#p3', 
							EMAIL = '#p4', 
							ULTIMACOMPRA = CURRENT_TIMESTAMP 
							WHERE DOCUMENTO = '#p1'";

$query["insertServParticular"] = "INSERT INTO SERVICIOS_PARTICULAR (NUMVOU, CODTOUR, DOCUMENTO, NOMPAX, 
																  CODHOT, CUARTOHOT, CODNAC, NUMPAX, 
																  PRECIOXPER, TOTAL, OBS, CODUSR, FDIGITA, TIPO, 
																  NUMPAX1, NUMPAX2, PRECIOXPER2, CODOFI) 
																  VALUES('#p1', '#p2', '#p3', '#p4',
																		'#p5', '#p6', '#p7', '#p8', 
																		'#p9', '#p10', '#p11', '#p12', #p13, '#p14', 
																		#p15, #p16, #p17, '#p18')";								
																			
																		
/*---------------------------------------------------U P D A T E S---------------------------------------------*/
$query["updateNumTransReservado"] = "UPDATE CONSECUTIVOS set estado = 'RES', fechares = #p3 WHERE tipo='#p2' and num = '#p1'";
$query["updateNumResReservado"] = "UPDATE CONSECUTIVOS set estado = 'RES', fechares = #p2 WHERE tipo='RES' and num = '#p1'";
$query["updateNumVouReservado"] = "UPDATE CONSECUTIVOS set estado = 'RES', fechares = #p2 WHERE tipo='VOU #p3' and num = '#p1'";

$query["updateNumResAnulado"] = "UPDATE CONSECUTIVOS set estado = 'ANU' WHERE tipo='RES' and num = '#p1'";
$query["updateNumTransAnulado"] = "UPDATE CONSECUTIVOS set estado = 'ANU' WHERE tipo='#p1' and num = '#p2'";

$query["updateConfirNumResReservado"] = "UPDATE CONSECUTIVOS set estado = 'OCU' WHERE tipo='RES' and num = '#p1'";
$query["updateConfirNumVouReservado"] = "UPDATE CONSECUTIVOS set estado = 'OCU' WHERE tipo='VOU #p2' and num = '#p1'";
$query["updateConfirNumTransReservado"] = "UPDATE CONSECUTIVOS set estado = 'USA' WHERE tipo='#p2' and num = '#p1'";

$query["updateLibNumResReservado"] = "UPDATE CONSECUTIVOS set estado = 'LIB', fechares = NULL WHERE tipo='RES' and num = '#p1' and estado = 'RES'";
$query["updateLibNumVouReservado"] = "UPDATE CONSECUTIVOS set estado = 'LIB', fechares = NULL WHERE tipo='VOU #p2' and num = '#p1' and estado = 'RES'";
$query["updateLibNumTransReservado"] = "UPDATE CONSECUTIVOS set estado = 'DIS', fechares = NULL WHERE tipo='#p2' and num = '#p1' and estado = 'RES'";
$query["updateLibConsecReservadosAnt"] = "UPDATE CONSECUTIVOS set estado = 'LIB', fechares = NULL WHERE estado = 'RES' and CONVERT(varchar, fechares, 112) <= #p1";

$query["updateConfirServiciosReserva"] = "UPDATE RESERVAS_TOUR SET numres = '#p1' WHERE numres = '#p2'";
$query["updateConfirTourReserva"] = "UPDATE RESERVAS_TOUR SET CONFIRMADA = 'SI' WHERE numres = '#p1' and resres = '#p2' and codser = '#p3'";
$query["updateCliente"] = "UPDATE CLIENTES SET 
							NOMCLI = '#p2', DIRCLI = '#p3', 
							CIUCLI = '#p4', TE1CLI = '#p5', 
							TE2CLI = '#p6', CELCLI ='#p7', 
							CONCLI = '#p8', TIPOCLI = '#p9', 
              NITCLI = '#p10' 
							WHERE CODCLI = '#p1'";

$query["updateServicio"] = "UPDATE SERVICIOS SET 
							NOMSER = '#p2', 
							SELDEFECTO = '#p3', 
							ORDENSALE = '#p4',
							PRECIOADU = '#p5',
							PRECIOINF = '#p6'
							WHERE CODSER = '#p1'";							

$query["updateUbicacion"] = "UPDATE UBICACIONES SET 
							NOMUBI = '#p2', 
							DIRUBI = '#p3', 
							TE1UBI = '#p4', 
							TE2UBI = '#p5', 
							CELUBI = '#p6', 
							CONUBI = '#p7',
							TIPOUBI = '#p8',
              CODOFI = '#p9' 
							WHERE CODUBI = '#p1'";
							
$query["updateUsuario"] = "UPDATE USUARIOS SET 
							CLAVE = '#p2', 
							CODROL = '#p3', 
							NOMBRE = '#p4', 
							APELLIDOS = '#p5', 
							CODUSRDIG = '#p6', 
							CODCLI = #p7 
							WHERE CODUSR = '#p1'";							

$query["updateNacionalidad"] = "UPDATE NACIONALIDADES SET 
							NACIONAL = '#p2' 
							WHERE CODNAC = '#p1'";

$query["updateProveedor"] = "UPDATE PROVEEDORES SET 
							NOMPRO = '#p2', 
							DIRPRO = '#p3', 
							TE1PRO = '#p4', 
							TE2PRO = '#p5', 
							CELPRO = '#p6', 
							CONPRO = '#p7'
							WHERE CODPRO = '#p1'";

$query["updatePaquete"] = "UPDATE PAQUETES 
                            SET 
                              NOMPAQ = '#p2', 
                              DESCPAQ = '#p3', 
                              CODOFI = '#p4'
                            WHERE CODPAQ = '#p1'";
              
$query["updateBorradaResDes"] = "UPDATE RESERVAS SET borrada = 'SI', codusr = '#p2' WHERE numres = '#p1'";
							
$query["updateBorradaResResDes"] = "UPDATE RESERVAS SET borrada = 'SI', codusr = '#p3' WHERE numres = '#p1' and resres = '#p2'";

$query["updateBorradaResResAct"] = "UPDATE RESERVAS SET borrada = NULL WHERE numres = '#p1' and resres = '#p2'";							

$query["updateBorradaVou"] = "UPDATE SERVICIOS_PARTICULAR SET borrado = 'SI' WHERE numvou = '#p1' and codofi = '#p2'";

$query["updateBorradaTour"] = "UPDATE TOURS SET borrado = 'SI' WHERE codtour = '#p1' and codofi = '#p2'";

$query["updatePassword"] = "UPDATE USUARIOS SET clave = '#p2' WHERE codusr = '#p1'";

/*---------------------------------------------------D E L E T E S---------------------------------------------*/
$query["deleteServiciosReserva"] = "DELETE FROM RESERVAS_TOUR WHERE numres = '#p1'";
$query["deleteReserva"] = "DELETE FROM RESERVAS WHERE numres = '#p1'";
$query["deleteCliente"] = "DELETE FROM CLIENTES WHERE CODCLI = '#p1'";
$query["deleteServicio"] = "DELETE FROM SERVICIOS WHERE CODSER = '#p1'";
$query["deleteUbicacion"] = "DELETE FROM UBICACIONES WHERE CODUBI = '#p1'";
$query["deleteUsuario"] = "DELETE FROM USUARIOS WHERE CODUSR = '#p1'";
$query["deleteNacionalidad"] = "DELETE FROM NACIONALIDADES WHERE CODNAC = '#p1'";
$query["deleteProveedoresServicio"] = "DELETE FROM SERVICIOSXPROVEEDOR WHERE codser = '#p1'";
$query["deleteProveedorServicio"] = "DELETE FROM SERVICIOSXPROVEEDOR WHERE codser = '#p1' and codpro = '#p2'";
$query["deleteProveedor"] = "DELETE FROM PROVEEDORES WHERE CODPRO = '#p1'";
$query["deletePaquete"] = "DELETE FROM PAQUETES WHERE CODPAQ = '#p1'";
$query["deleteVuelo"] = "DELETE FROM VUELOS WHERE tipovlo = '#p1' and nrovlo = '#p2'";
$query["deleteConsecutivo"] = "DELETE FROM CONSECUTIVOS WHERE tipo = '#p1' and num = '#p2'";
$query["deleteConsecutivoLib"] = "DELETE FROM CONSECUTIVOS WHERE tipo = '#p1' and num = '#p2' and estado = 'DIS'";

$query["deleteReporteLog1"] = "DELETE 
							FROM LOGS WITH (INDEX(idx_tabla_num_logs)) 
							WHERE tabla = '#p3' AND 
								  num = '#p4' AND 
								  codusr like '#p1' AND 
								  tipo like '#p2' AND 
                  codofi like '#p5'";

$query["deleteReporteLog2"] = "DELETE 
							FROM LOGS 
							WHERE tabla = '#p5' AND 
								  CONVERT(varchar, fecha, 112) >= '#p1' AND 
								  CONVERT(varchar, fecha, 112) <= '#p2' AND
								  codusr like '#p3' AND 
								  tipo like '#p4' AND 								  
								  num like '#p6' AND 
                  codofi like '#p7'";							
/*
$query[""] = "";
*/

function getSql($nomConsulta,$p1="<NULL>", $p2="<NULL>", $p3="<NULL>", $p4="<NULL>", $p5="<NULL>", 
							 $p6="<NULL>", $p7="<NULL>", $p8="<NULL>", $p9="<NULL>", $p10="<NULL>",
							 $p11="<NULL>", $p12="<NULL>", $p13="<NULL>", $p14="<NULL>", $p15="<NULL>",
							 $p16="<NULL>", $p17="<NULL>", $p18="<NULL>", $p19="<NULL>", $p20="<NULL>",
               $p21="<NULL>", $p22="<NULL>", $p23="<NULL>", $p24="<NULL>", $p25="<NULL>")
{
	global $query;	
	$queryBase = "";
	$arr = array();
	/*$arr[1] = $p1;		$arr[2] = $p2;
	$arr[3] = $p3;		$arr[4] = $p4;
	$arr[5] = $p5;		$arr[6] = $p6;
	$arr[7] = $p7;		$arr[8] = $p8;
	$arr[9] = $p9;		$arr[10] = $p10;
	$arr[11] = $p11;	$arr[12] = $p12;
	$arr[13] = $p13;	$arr[14] = $p14;
	$arr[15] = $p15;	$arr[16] = $p16;
	$arr[17] = $p17;	$arr[18] = $p18;
	$arr[19] = $p19;	$arr[20] = $p20;*/
	
	$arr[1] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p1));
	$arr[2] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p2));
	$arr[3] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p3));
	$arr[4] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p4));
	$arr[5] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p5));
	$arr[6] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p6));
	$arr[7] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p7));
	$arr[8] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p8));
	$arr[9] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p9));
	$arr[10] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p10));
	$arr[11] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p11));
	$arr[12] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p12));
	$arr[13] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p13));
	$arr[14] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p14));
	$arr[15] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p15));
	$arr[16] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p16));
	$arr[17] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p17));
	$arr[18] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p18));
	$arr[19] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p19));
	$arr[20] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p20));
	$arr[21] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p21));
	$arr[22] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p22));
	$arr[23] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p23));
	$arr[24] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p24));
	$arr[25] = str_replace(chr(13), ' ', str_replace(chr(10), ' ',$p25));
	
	$queryBase = $query[$nomConsulta];	
		
	$result = replaceParams($queryBase, $arr);
	return $result;
}

function replaceParams($base, $params){
	$res = $base;
	for ($i=count($params);$i>=1;$i--){
		$pr = "#p".($i);
		$res = str_replace($pr,$params[$i],$res);
	}
	return $res;
}
?>