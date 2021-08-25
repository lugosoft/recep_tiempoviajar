CREATE FUNCTION dbo.getFechaInterfaz(@pFecha DATETIME)
returns varchar(12)
as
BEGIN
  return SUBSTRING(CONVERT(varchar, @pFecha, 112),7,2)+'/'+SUBSTRING(CONVERT(varchar, @pFecha, 112),5,2)+'/'+SUBSTRING(CONVERT(varchar, @pFecha, 112),1,4);        
END

GO


-- Otra forma de crearla
CREATE FUNCTION dbo.getFechaInterfaz(@pFecha DATETIME)
returns varchar(12)
as
BEGIN
  return SUBSTRING(CONVERT(varchar, @pFecha, 112),7,2)+'/'+SUBSTRING(CONVERT(varchar, @pFecha, 112),5,2)+'/'+SUBSTRING(CONVERT(varchar, @pFecha, 112),1,4)
END;